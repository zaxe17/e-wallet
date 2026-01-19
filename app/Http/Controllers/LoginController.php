<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    // Show login page
    public function index()
    {
        return view('pages.login');
    }

    // Handle login form submission
    public function store(Request $request)
    {
        $request->validate([
            'email_username' => 'required|string',
            'password' => 'required|string',
        ]);

        try {
            // Get user by email or username
            $user = DB::selectOne("
                SELECT * FROM user 
                WHERE email_address = ? OR username = ?
                LIMIT 1
            ", [
                $request->email_username,
                $request->email_username
            ]);

            // Check if user exists and password matches
            if (!$user || !Hash::check($request->password, $user->password)) {
                return redirect()->back()
                    ->with('error', 'Invalid email/username or password.')
                    ->withInput($request->only('email_username'));
            }

            // Store user info in session
            Session::put('user_id', $user->userid);
            Session::put('username', $user->username);
            Session::put('full_name', $user->full_name);
            Session::put('email', $user->email_address);

            // Create budget cycle for this month if it doesn't exist
            // $this->createMonthlyCycleIfNeeded($user->userid);

            return redirect()->route('dashboard.index')
                ->with('success', 'Welcome back, ' . $user->full_name . '!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Login failed. Please try again.')
                ->withInput($request->only('email_username'));
        }
    }

    // Generate new cycle ID
    /* private function generateCycleId()
    {
        $last = DB::table('budget_cycles')->orderBy('cycle_id', 'desc')->first();
        if (!$last) return 'CYC-000001';

        $num = intval(substr($last->cycle_id, 4)) + 1;
        return 'CYC-' . str_pad($num, 6, '0', STR_PAD_LEFT);
    }

    // Create budget cycle for current month if not exists
    private function createMonthlyCycleIfNeeded($userId)
    {
        $monthStart = now()->startOfMonth()->toDateString();
        $monthEnd   = now()->endOfMonth()->toDateString();

        // Check if cycle for this month already exists
        $exists = DB::table('budget_cycles')
            ->where('userid', $userId)
            ->where('start_date', $monthStart)
            ->exists();

        if (!$exists) {
            // Deactivate previous cycles
            DB::table('budget_cycles')
                ->where('userid', $userId)
                ->update(['is_active' => 0]);

            // Create new cycle for this month
            DB::insert("
            INSERT INTO budget_cycles
            (cycle_id, userid, start_date, end_date, cycle_name,
             total_income, total_expense, total_savings,
             budget_remarks, is_active, rollover_amount)
            VALUES (?, ?, ?, ?, ?, 0, 0, 0, NULL, 1, 0)
        ", [
                $this->generateCycleId(),
                $userId,
                $monthStart,
                $monthEnd,
                now()->format('F Y')
            ]);
        }
    } */
}