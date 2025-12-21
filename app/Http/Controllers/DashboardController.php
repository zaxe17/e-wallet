<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index()
    {
        $navtitle = 'Dashboard';

        // Get user_id from session
        $userId = Session::get('user_id');

        // Get user information
        $userSql = "SELECT full_name, payday_cutoff FROM `user` WHERE userid = ?";
        $users = DB::select($userSql, [$userId]);
        $user = $users[0] ?? null;

        // Get total earnings
        $earningSql = "
            SELECT IFNULL(SUM(amount), 0) AS total_earnings
            FROM earnings
            WHERE in_id = ?
        ";
        $earnings = DB::select($earningSql, [$userId]);
        $totalEarnings = $earnings[0]->total_earnings ?? 0;

        // Get total expenses
        $expenseSql = "
            SELECT IFNULL(SUM(amount), 0) AS total_expenses
            FROM expenses
            WHERE out_id = ?
        ";
        $expenses = DB::select($expenseSql, [$userId]);
        $totalExpenses = $expenses[0]->total_expenses ?? 0;

        // Get total savings (including interest)
        $savingsSql = "
            SELECT IFNULL(SUM(savings_amount + interest_earned), 0) AS total_savings
            FROM savings
            WHERE userid = ?
        ";
        $savings = DB::select($savingsSql, [$userId]);
        $totalSavings = $savings[0]->total_savings ?? 0;

        // Calculate remaining budget
        $remainingBudget = $totalEarnings - $totalExpenses;

        return view('pages.dashboard', compact(
            'navtitle',
            'user',
            'totalEarnings',
            'totalExpenses',
            'totalSavings',
            'remainingBudget'
        ));
    }
}
