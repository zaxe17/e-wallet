<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index()
    {
        $navtitle = 'Dashboard';
        $userId = Session::get('user_id');

        $user = $this->getUserInfo($userId);
        $totalEarnings = $this->getTotalEarnings($userId);
        $totalExpenses = $this->getTotalExpenses($userId);
        $totalSavings  = $this->getTotalSavings($userId);
        $monthList  = $this->months();
        $currentMonth = date('F');

        $remainingBudget = $totalEarnings - $totalExpenses;

        return view('pages.dashboard', compact(
            'navtitle',
            'user',
            'totalEarnings',
            'totalExpenses',
            'totalSavings',
            'remainingBudget',
            'monthList',
            'currentMonth'
        ));
    }

    private function getUserInfo($userId)
    {
        $sql = "SELECT full_name, payday_cutoff FROM `user` WHERE userid = ?";
        $result = DB::select($sql, [$userId]);

        return $result[0] ?? null;
    }

    private function getTotalEarnings($userId)
    {
        $sql = "
            SELECT total_income AS total_earnings
            FROM budget_cycles
            WHERE userid = ?
        ";

        return DB::select($sql, [$userId])[0]->total_earnings ?? 0;
    }

    private function getTotalExpenses($userId)
    {
        $sql = "
            SELECT total_expense AS total_expenses
            FROM budget_cycles
            WHERE userid = ?
        ";

        return DB::select($sql, [$userId])[0]->total_expenses ?? 0;
    }

    private function getTotalSavings($userId)
    {
        $sql = "
            SELECT total_savings AS total_savings
            FROM budget_cycles
            WHERE userid = ?
        ";

        return DB::select($sql, [$userId])[0]->total_savings ?? 0;
    }

    private function months()
    {
        $months = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];

        return $months;
    }
}
