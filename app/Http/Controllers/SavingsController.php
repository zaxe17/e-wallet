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
                GROUP_CONCAT(description SEPARATOR ', ') AS description,
                SUM(savings_amount) AS savings_amount,
                MAX(date_of_save) AS date_of_save,
                ROUND(SUM(interest_earned), 2) AS interest_earned,
                ROUND(AVG(interest_rate), 2) AS interest_rate,
                ROUND(SUM(savings_amount + interest_earned), 2) AS total_with_interest
            FROM savings
            WHERE userid = ?
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
            $existing = DB::selectOne("
                SELECT savingsno, savings_amount, interest_rate, description
                FROM savings
                WHERE userid = ? AND bank = ?
                LIMIT 1
            ", [$userId, $request->bank ?? '']);

            if ($existing) {
                $newAmount = $existing->savings_amount + $request->savings_amount;

                $newDescription = $existing->description;
                if ($request->description && $request->description !== $existing->description) {
                    $newDescription .= ', ' . $request->description;
                }

                DB::update("
                    UPDATE savings
                    SET savings_amount = ?,
                        date_of_save = ?,
                        interest_rate = ?,
                        description = ?
                    WHERE savingsno = ? AND userid = ?
                ", [
                    $newAmount,
                    $request->date_of_save,
                    $request->interest_rate ?? $existing->interest_rate,
                    $newDescription,
                    $existing->savingsno,
                    $userId
                ]);

                return redirect()
                    ->route('savings.index')
                    ->with('success', 'Savings updated. New amount: ₱' . number_format($newAmount, 2));
            }

            DB::insert("
                INSERT INTO savings
                (userid, bank, description, savings_amount, date_of_save, interest_rate)
                VALUES (?, ?, ?, ?, ?, ?)
            ", [
                $userId,
                $request->bank,
                $request->description,
                $request->savings_amount,
                $request->date_of_save,
                $request->interest_rate ?? 0
            ]);

            return redirect()
                ->route('savings.index')
                ->with('success', 'Added successfully.');
        } catch (\Throwable $e) {
            Log::error('Savings error: ' . $e->getMessage());
            return back()->with('error', 'Failed to save savings.');
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
