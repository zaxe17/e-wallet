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

        // Get user_id from session
        $userId = Session::get('user_id');

        // Get total savings INCLUDING interest earned using raw SQL
        $totalSql = "SELECT IFNULL(SUM(savings_amount + interest_earned), 0) as total_savings FROM savings WHERE userid = ?";
        $totalResult = DB::select($totalSql, [$userId]);
        $totalSavings = $totalResult[0]->total_savings;

        // Get all savings records grouped by bank with combined amounts INCLUDING interest
        $savingsSql = "
            SELECT 
                MIN(savingsno) as savingsno,
                bank,
                GROUP_CONCAT(description SEPARATOR ', ') as description,
                SUM(savings_amount) as savings_amount,
                MAX(date_of_save) as date_of_save,
                ROUND(SUM(interest_earned), 2) as interest_earned,
                ROUND(AVG(interest_rate), 2) as interest_rate,
                ROUND(SUM(savings_amount + interest_earned), 2) as total_with_interest,
                MIN(passkey) as passkey
            FROM savings 
            WHERE userid = ? 
            GROUP BY bank
            ORDER BY date_of_save DESC
        ";
        $savings = DB::select($savingsSql, [$userId]);

        // Add no-cache headers to ensure fresh data
        return response()
            ->view('pages.savings', compact('navtitle', 'totalSavings', 'savings'))
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'bank' => 'nullable|string|max:20',
            'description' => 'nullable|string|max:30',
            'savings_amount' => 'required|numeric|min:0',
            'date_of_save' => 'required|date',
            'interest_rate' => 'nullable|numeric|min:0',
            'passkey' => 'required|digits:4'
        ]);

        // Get user_id from session
        $userId = Session::get('user_id');

        // Verify user exists
        $userCheckSql = "SELECT userid FROM user WHERE userid = ?";
        $userResult = DB::select($userCheckSql, [$userId]);

        if (empty($userResult)) {
            return redirect()->back()->with('error', 'User not found');
        }

        try {
            // Check if savings record with same bank exists (regardless of description)
            $existingSql = "
                SELECT savingsno, savings_amount, interest_rate, description 
                FROM savings 
                WHERE userid = ? AND bank = ?
                LIMIT 1
            ";

            $bankValue = $request->bank ?? '';

            $existingRecord = DB::select($existingSql, [$userId, $bankValue]);

            if (!empty($existingRecord)) {
                // Update existing record - add to the current amount
                $newAmount = $existingRecord[0]->savings_amount + $request->savings_amount;

                // Combine descriptions if different
                $newDescription = $existingRecord[0]->description;
                if ($request->description && $request->description != $existingRecord[0]->description) {
                    $newDescription = $existingRecord[0]->description . ', ' . $request->description;
                }

                $updateSql = "
                    UPDATE savings 
                    SET savings_amount = ?, 
                        date_of_save = ?, 
                        interest_rate = ?,
                        description = ?,
                        passkey = ?
                    WHERE savingsno = ? AND userid = ?
                ";

                DB::update($updateSql, [
                    $newAmount,
                    $request->date_of_save,
                    $request->interest_rate ?? $existingRecord[0]->interest_rate,
                    $newDescription,
                    $request->passkey,
                    $existingRecord[0]->savingsno,
                    $userId
                ]);

                return redirect()->route('savings.index')->with('success', 'Savings updated successfully. New amount: ₱' . number_format($newAmount, 2));
            } else {
                // Insert new savings record
                $insertSql = "
                    INSERT INTO savings (userid, bank, description, savings_amount, date_of_save, interest_rate, passkey) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)
                ";

                DB::insert($insertSql, [
                    $userId,
                    $request->bank,
                    $request->description,
                    $request->savings_amount,
                    $request->date_of_save,
                    $request->interest_rate ?? 0,
                    $request->passkey
                ]);

                return redirect()->route('savings.index')->with('success', 'New savings account created successfully');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to add savings: ' . $e->getMessage());
        }
    }

    public function validatePasskey(Request $request)
    {
        // Retrieve the entered passkey and user ID
        $enteredPasskey = trim($request->input('passkey'));
        $userId = Session::get('user_id');

        // Log entered passkey and user ID for debugging
        Log::info('Entered Passkey: ' . $enteredPasskey);
        Log::info('User ID from session: ' . $userId);

        // Retrieve the stored passkey for the user
        $storedPasskey = DB::selectOne(
            "SELECT passkey FROM savings WHERE userid = ? ORDER BY date_of_save DESC LIMIT 1",
            [$userId]  // Passing the userId as a parameter
        );
        
        // Check if the stored passkey exists
        if ($storedPasskey && isset($storedPasskey->passkey)) {
            // Ensure both values are of the same type (string comparison)
            $storedPasskeyValue = (string) $storedPasskey->passkey;

            // Log the passkey being compared
            Log::info('Stored Passkey for User ' . $userId . ': ' . $storedPasskeyValue);

            // Check if the entered passkey matches the stored passkey
            if ($enteredPasskey === $storedPasskeyValue) {
                Log::info('Passkey match found for User ' . $userId);
                return response()->json(['valid' => true]);
            } else {
                Log::info('Invalid passkey entered for User ' . $userId);
                return response()->json(['valid' => false]);
            }
        } else {
            Log::info('No passkey found for User ' . $userId);
            return response()->json(['valid' => false]);
        }
    }
}
