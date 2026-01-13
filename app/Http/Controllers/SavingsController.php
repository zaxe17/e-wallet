<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class SavingsController extends Controller
{
    public function index()
    {
        $navtitle = 'Savings';
        $userId = Session::get('user_id');

        // TOTAL SAVINGS (INCLUDING INTEREST)
        $totalSql = "
            SELECT IFNULL(SUM(savings_amount + interest_earned), 0) AS total_savings
            FROM savings
            WHERE userid = ?
        ";
        $totalSavings = DB::selectOne($totalSql, [$userId])->total_savings ?? 0;

        // GROUPED SAVINGS BY BANK
        $savingsSql = "
            SELECT 
                MIN(savingsno) AS savingsno,
                bank,
                GROUP_CONCAT(DISTINCT TRIM(description) ORDER BY description SEPARATOR ', ') AS description,
                SUM(savings_amount) AS savings_amount,
                MAX(date_of_save) AS date_of_save,
                ROUND(SUM(interest_earned), 2) AS interest_earned,
                ROUND(AVG(interest_rate), 2) AS interest_rate,
                ROUND(SUM(savings_amount + interest_earned), 2) AS total_with_interest
            FROM savings
            WHERE userid = ?
            GROUP BY bank
            ORDER BY MAX(date_of_save) DESC
        ";
        $savings = DB::select($savingsSql, [$userId]);

        return response()
            ->view('pages.savings', compact('navtitle', 'totalSavings', 'savings'))
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function store(Request $request)
    {
        $request->validate([
            'bank' => 'required|string|max:20',
            'description' => 'nullable|string|max:255',
            'savings_amount' => 'required|numeric|min:0',
            'date_of_save' => 'required|date',
            'interest_rate' => 'nullable|numeric|min:0',
        ]);

        $userId = Session::get('user_id');

        try {
            DB::beginTransaction();

            Log::info('Store Savings Request', [
                'user_id' => $userId,
                'bank' => $request->bank,
                'description' => $request->description,
                'amount' => $request->savings_amount
            ]);

            // Check if savings for this bank already exists
            $existingSavings = DB::selectOne("
                SELECT savingsno, savings_amount, interest_rate, description
                FROM savings
                WHERE userid = ? AND bank = ?
                LIMIT 1
            ", [$userId, $request->bank]);

            if ($existingSavings) {
                // Update existing savings
                $interestRate = $request->interest_rate ?? $existingSavings->interest_rate;

                // Merge descriptions without duplicates
                $existingDesc = trim($existingSavings->description ?? '');
                $newDesc = trim($request->description ?? '');

                if (!empty($newDesc)) {
                    $existingDescArray = array_filter(array_map('trim', explode(',', $existingDesc)));
                    $newDescArray = array_filter(array_map('trim', explode(',', $newDesc)));
                    $allDescriptions = array_merge($existingDescArray, $newDescArray);

                    $uniqueDescriptions = [];
                    $lowerCaseCheck = [];

                    foreach ($allDescriptions as $desc) {
                        if (!empty($desc)) {
                            $lowerDesc = strtolower($desc);
                            if (!in_array($lowerDesc, $lowerCaseCheck)) {
                                $uniqueDescriptions[] = $desc;
                                $lowerCaseCheck[] = $lowerDesc;
                            }
                        }
                    }

                    $mergedDescription = implode(', ', $uniqueDescriptions);
                } else {
                    $mergedDescription = $existingDesc;
                }

                // Update savings
                DB::update("
                    UPDATE savings
                    SET interest_rate = ?, description = ?, date_of_save = ?
                    WHERE savingsno = ?
                ", [$interestRate, $mergedDescription, $request->date_of_save, $existingSavings->savingsno]);

                $savingsno = $existingSavings->savingsno;
                
                Log::info('Updated existing savings', ['savingsno' => $savingsno]);
            } else {
                // Let the trigger generate savingsno by inserting with NULL
                $interestRate = $request->interest_rate ?? 0;

                DB::statement("
                    INSERT INTO savings (savingsno, userid, bank, description, savings_amount, date_of_save, interest_rate)
                    VALUES (NULL, ?, ?, ?, ?, ?, ?)
                ", [
                    $userId,
                    $request->bank,
                    $request->description ?? '',
                    0, // Start at 0, transaction trigger will add the amount
                    $request->date_of_save,
                    $interestRate
                ]);

                // Get the generated savingsno
                $result = DB::selectOne("
                    SELECT savingsno 
                    FROM savings 
                    WHERE userid = ? AND bank = ? 
                    ORDER BY savingsno DESC 
                    LIMIT 1
                ", [$userId, $request->bank]);

                $savingsno = $result->savingsno;

                Log::info('New Savings Created', ['savingsno' => $savingsno]);
            }

            // Insert transaction record (trigger will generate trans_id)
            DB::statement("
                INSERT INTO savings_transactions (trans_id, savingsno, trans_type, amount, trans_date)
                VALUES (NULL, ?, 'DEPOSIT', ?, ?)
            ", [$savingsno, $request->savings_amount, $request->date_of_save]);

            Log::info('Transaction Inserted', ['savingsno' => $savingsno, 'amount' => $request->savings_amount]);

            DB::commit();

            return redirect()
                ->route('savings.index')
                ->with('success', 'Savings added successfully.');

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Savings error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return back()
                ->withInput()
                ->with('error', 'Failed to save savings: ' . $e->getMessage());
        }
    }

    public function deposit(Request $request)
    {
        $request->validate([
            'bank' => 'required|string|max:20',
            'description' => 'nullable|string|max:255',
            'savings_amount' => 'required|numeric|min:0',
            'interest_rate' => 'nullable|numeric|min:0',
        ]);

        $userId = Session::get('user_id');

        try {
            DB::beginTransaction();

            // Find existing savings for this bank
            $existingSavings = DB::selectOne("
                SELECT savingsno, savings_amount, interest_rate, description
                FROM savings
                WHERE userid = ? AND bank = ?
                LIMIT 1
            ", [$userId, $request->bank]);

            if ($existingSavings) {
                // Update existing savings
                $interestRate = $request->interest_rate ?? $existingSavings->interest_rate;

                // Merge descriptions without duplicates
                $existingDesc = trim($existingSavings->description ?? '');
                $newDesc = trim($request->description ?? '');

                if (!empty($newDesc)) {
                    $existingDescArray = array_filter(array_map('trim', explode(',', $existingDesc)));
                    $newDescArray = array_filter(array_map('trim', explode(',', $newDesc)));
                    $allDescriptions = array_merge($existingDescArray, $newDescArray);

                    $uniqueDescriptions = [];
                    $lowerCaseCheck = [];

                    foreach ($allDescriptions as $desc) {
                        if (!empty($desc)) {
                            $lowerDesc = strtolower($desc);
                            if (!in_array($lowerDesc, $lowerCaseCheck)) {
                                $uniqueDescriptions[] = $desc;
                                $lowerCaseCheck[] = $lowerDesc;
                            }
                        }
                    }

                    $mergedDescription = implode(', ', $uniqueDescriptions);
                } else {
                    $mergedDescription = $existingDesc;
                }

                DB::update("
                    UPDATE savings
                    SET interest_rate = ?, description = ?
                    WHERE savingsno = ?
                ", [$interestRate, $mergedDescription, $existingSavings->savingsno]);

                $savingsno = $existingSavings->savingsno;
            } else {
                // Let trigger generate savingsno
                $interestRate = $request->interest_rate ?? 0;

                DB::statement("
                    INSERT INTO savings (savingsno, userid, bank, description, savings_amount, date_of_save, interest_rate)
                    VALUES (NULL, ?, ?, ?, ?, NOW(), ?)
                ", [
                    $userId,
                    $request->bank,
                    $request->description,
                    0, // Start at 0, transaction trigger will add the amount
                    $interestRate
                ]);

                // Get the generated savingsno
                $result = DB::selectOne("
                    SELECT savingsno 
                    FROM savings 
                    WHERE userid = ? AND bank = ? 
                    ORDER BY savingsno DESC 
                    LIMIT 1
                ", [$userId, $request->bank]);

                $savingsno = $result->savingsno;
            }

            // Insert transaction record (trigger generates trans_id)
            DB::statement("
                INSERT INTO savings_transactions (trans_id, savingsno, trans_type, amount, trans_date)
                VALUES (NULL, ?, 'DEPOSIT', ?, NOW())
            ", [$savingsno, $request->savings_amount]);

            DB::commit();

            return redirect()
                ->route('savings.index')
                ->with('success', 'Deposit added successfully.');

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Deposit error: ' . $e->getMessage());

            return back()->with('error', 'Failed to add deposit: ' . $e->getMessage());
        }
    }

    public function updateSavings(Request $request, $savingsno)
    {
        $request->validate([
            'interest_rate' => 'required|numeric|min:0',
            'date_of_save' => 'required|date',
        ]);

        $userId = Session::get('user_id');

        try {
            // Fetch existing record
            $existing = DB::selectOne("
                SELECT savingsno FROM savings 
                WHERE savingsno = ? AND userid = ?
            ", [$savingsno, $userId]);

            if (!$existing) {
                return redirect()->route('savings.index')->with('error', 'Savings record not found.');
            }

            // Update the interest rate and date
            DB::update("
                UPDATE savings
                SET interest_rate = ?,
                    date_of_save = ?
                WHERE savingsno = ? AND userid = ?
            ", [
                $request->interest_rate,
                $request->date_of_save,
                $savingsno,
                $userId
            ]);

            return redirect()->route('savings.index')
                ->with('success', 'Savings updated successfully.');
        } catch (\Throwable $e) {
            Log::error('Savings update error: ' . $e->getMessage());
            return back()->with('error', 'Failed to update savings.');
        }
    }

    public function deleteSavings($savingsno)
    {
        $userId = Session::get('user_id');

        try {
            DB::beginTransaction();

            Log::info('Starting delete savings', ['savingsno' => $savingsno, 'userid' => $userId]);

            // Verify the savings record exists and belongs to the user
            $existing = DB::selectOne(
                "SELECT savingsno, savings_amount, bank FROM savings WHERE savingsno = ? AND userid = ?",
                [$savingsno, $userId]
            );

            if (!$existing) {
                DB::rollBack();
                Log::error('Savings not found', ['savingsno' => $savingsno]);
                return redirect()->route('savings.index')->with('error', 'Savings record not found.');
            }

            Log::info('Found savings to delete', [
                'savingsno' => $existing->savingsno,
                'amount' => $existing->savings_amount,
                'bank' => $existing->bank
            ]);

            // Ensure user has an active budget cycle (create if needed)
            $activeCycle = DB::selectOne(
                "SELECT cycle_id FROM budget_cycles WHERE userid = ? AND is_active = 1 LIMIT 1",
                [$userId]
            );

            if (!$activeCycle && $existing->savings_amount > 0) {
                Log::info('No active cycle found, creating one');
                $maxCycleId = DB::selectOne(
                    "SELECT MAX(CAST(SUBSTRING(cycle_id, 7) AS UNSIGNED)) as max_id FROM budget_cycles WHERE userid = ?",
                    [$userId]
                );
                $nextCycleId = ($maxCycleId && $maxCycleId->max_id) ? $maxCycleId->max_id + 1 : 1;
                $newCycleId = 'CYCLE-' . str_pad($nextCycleId, 6, '0', STR_PAD_LEFT);

                DB::insert(
                    "INSERT INTO budget_cycles (cycle_id, userid, start_date, end_date, total_income, total_expense, total_savings, is_active) 
                    VALUES (?, ?, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 1 MONTH), 0, 0, 0, 1)",
                    [$newCycleId, $userId]
                );

                Log::info('Created new cycle', ['cycle_id' => $newCycleId]);
            }

            // Delete related transactions first (to avoid FK constraint issues)
            $deletedTransactions = DB::delete("DELETE FROM savings_transactions WHERE savingsno = ?", [$savingsno]);
            Log::info('Deleted transactions', ['count' => $deletedTransactions]);

            // Delete the savings record - trigger will handle expense creation and budget update
            $deletedSavings = DB::delete("DELETE FROM savings WHERE savingsno = ? AND userid = ?", [$savingsno, $userId]);
            Log::info('Deleted savings', ['count' => $deletedSavings]);

            if ($deletedSavings === 0) {
                DB::rollBack();
                Log::error('Failed to delete savings - no rows affected');
                return redirect()->route('savings.index')->with('error', 'Failed to delete savings record.');
            }

            DB::commit();
            Log::info('Transaction committed successfully');

            return redirect()->route('savings.index')
                ->with('success', 'Savings deleted and converted to expense successfully.');

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Delete savings error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->route('savings.index')->with('error', 'Failed to delete savings: ' . $e->getMessage());
        }
    }

    public function validatePasskey(Request $request)
    {
        $enteredPasskey = trim($request->input('passkey'));
        $userId = Session::get('user_id');

        $stored = DB::selectOne(
            "SELECT passkey FROM user WHERE userid = ? LIMIT 1",
            [$userId]
        );

        if ($stored && (string)$stored->passkey === $enteredPasskey) {
            return response()->json(['valid' => true]);
        }

        return response()->json(['valid' => false]);
    }

    public function checkPasskey()
    {
        $user = DB::selectOne(
            "SELECT passkey FROM user WHERE userid = ?",
            [Session::get('user_id')]
        );

        return response()->json([
            'is_null' => is_null($user?->passkey)
        ]);
    }

    public function withdraw(Request $request)
    {
        $request->validate([
            'bank' => 'required|string|max:20',
            'savings_amount' => 'required|numeric|min:0',
        ]);

        $userId = Session::get('user_id');

        try {
            DB::beginTransaction();

            // Find the savings record for this bank
            $existingSavings = DB::selectOne("
                SELECT savingsno, savings_amount, interest_rate, interest_earned
                FROM savings
                WHERE userid = ? AND bank = ?
                LIMIT 1
            ", [$userId, $request->bank]);

            if (!$existingSavings) {
                return back()->with('error', 'No savings found for this bank.');
            }

            // Calculate total available balance (principal + interest)
            $totalBalance = $existingSavings->savings_amount + $existingSavings->interest_earned;

            if ($totalBalance < $request->savings_amount) {
                return back()->with('error', 'Insufficient savings balance. Available: ₱' . number_format($totalBalance, 2));
            }

            // Insert transaction record - trigger will handle the balance update and trans_id
            DB::statement("
                INSERT INTO savings_transactions (trans_id, savingsno, trans_type, amount, trans_date)
                VALUES (NULL, ?, 'WITHDRAWAL', ?, NOW())
            ", [$existingSavings->savingsno, $request->savings_amount]);

            DB::commit();

            return redirect()
                ->route('savings.index')
                ->with('success', 'Withdrawal processed successfully.');

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Withdrawal error: ' . $e->getMessage());

            return back()->with('error', 'Failed to process withdrawal: ' . $e->getMessage());
        }
    }

    public function savePasskey(Request $request)
    {
        $request->validate([
            'passkey' => 'required|digits:4'
        ]);

        DB::update(
            "UPDATE user SET passkey = ? WHERE userid = ?",
            [$request->passkey, Session::get('user_id')]
        );

        return response()->json(['saved' => true]);
    }
}