<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index() {
        $navtitle = 'Dashboard';
        
        // Get user_id from session
        $userId = Session::get('user_id');
        
        // Get user information
        $userSql = "SELECT full_name, budget FROM user WHERE userid = ?";
        $users = DB::select($userSql, [$userId]);
        $user = !empty($users) ? $users[0] : null;
        
        // Get total earnings using raw SQL
        $earningSql = "SELECT IFNULL(SUM(amount), 0) as total_earnings FROM earnings WHERE userid = ?";
        $earnings = DB::select($earningSql, [$userId]);
        $totalEarnings = $earnings[0]->total_earnings;
        
        // Get total expenses using raw SQL
        $expenseSql = "SELECT IFNULL(SUM(cashout_amount), 0) as total_expenses FROM expenses WHERE userid = ?";
        $expenses = DB::select($expenseSql, [$userId]);
        $totalExpenses = $expenses[0]->total_expenses;
        
        // Get total savings INCLUDING interest earned using raw SQL
        $savingsSql = "SELECT IFNULL(SUM(savings_amount + interest_earned), 0) as total_savings FROM savings WHERE userid = ?";
        $savings = DB::select($savingsSql, [$userId]);
        $totalSavings = $savings[0]->total_savings;
        
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