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
            WHERE userid = ? AND TRIM(IFNULL(description, '')) != ''
            GROUP BY bank
            ORDER BY date_of_save DESC
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
            'bank' => 'nullable|string|max:20',
            'description' => 'nullable|string|max:30',
            'savings_amount' => 'required|numeric|min:0',
            'date_of_save' => 'required|date',
            'interest_rate' => 'nullable|numeric|min:0',
        ]);

        $userId = Session::get('user_id');

        try {
            // Use stored procedure to add savings transaction
            // This will handle both new savings and deposits to existing savings
            DB::statement("CALL AddSavingsTransaction(?, ?, ?, 'DEPOSIT', ?, ?)", [
                $userId,
                $request->bank,
                $request->savings_amount,
                $request->interest_rate ?? 0,
                $request->description
            ]);

            return redirect()
                ->route('savings.index')
                ->with('success', 'Savings added successfully.');
        } catch (\Throwable $e) {
            Log::error('Savings error: ' . $e->getMessage());
            return back()->with('error', 'Failed to save savings.');
        }
    }

    public function deposit(Request $request)
    {
        $request->validate([
            'bank' => 'required|string|max:20',
            'description' => 'nullable|string|max:30',
            'savings_amount' => 'required|numeric|min:0',
            'interest_rate' => 'nullable|numeric|min:0',
        ]);

        $userId = Session::get('user_id');

        try {
            // Use stored procedure to add deposit transaction
            DB::statement("CALL AddSavingsTransaction(?, ?, ?, 'DEPOSIT', ?, ?)", [
                $userId,
                $request->bank,
                $request->savings_amount,
                $request->interest_rate ?? 0,
                $request->description
            ]);

            return redirect()
                ->route('savings.index')
                ->with('success', 'Deposit added successfully.');
        } catch (\Throwable $e) {
            Log::error('Deposit error: ' . $e->getMessage());
            return back()->with('error', 'Failed to add deposit.');
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
            $existing = DB::selectOne(
                "SELECT savingsno FROM savings WHERE savingsno = ? AND userid = ?",
                [$savingsno, $userId]
            );

            if (!$existing) {
                return redirect()->route('savings.index')->with('error', 'Savings record not found.');
            }

            // Delete the savings record
            // Trigger trg_delete_savings_convert_to_expense will automatically:
            // 1. Update budget_cycles.total_savings
            // 2. Insert into expenses with category 'Deleted: {bank}'
            DB::delete(
                "DELETE FROM savings WHERE savingsno = ? AND userid = ?",
                [$savingsno, $userId]
            );

            return redirect()->route('savings.index')->with('success', 'Savings deleted successfully.');
        } catch (\Throwable $e) {
            Log::error('Delete savings error: ' . $e->getMessage());
            return redirect()->route('savings.index')->with('error', 'Failed to delete savings.');
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
            // Use stored procedure to add withdrawal transaction
            DB::statement("CALL AddSavingsTransaction(?, ?, ?, 'WITHDRAWAL', ?, ?)", [
                $userId,
                $request->bank,
                $request->savings_amount,
                0, // interest_rate not needed for withdrawal
                null // description not needed for withdrawal
            ]);

            return redirect()
                ->route('savings.index')
                ->with('success', 'Withdrawal processed successfully.');
        } catch (\Throwable $e) {
            Log::error('Withdrawal error: ' . $e->getMessage());
            return back()->with('error', 'Failed to process withdrawal.');
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