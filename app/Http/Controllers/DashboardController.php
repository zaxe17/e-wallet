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
        $activeCycle = $this->getActiveBudgetCycle($userId);
        
        $totalEarnings = $activeCycle->total_income ?? 0;
        $totalExpenses = $activeCycle->total_expense ?? 0;
        $totalSavings = $activeCycle->total_savings ?? 0;
        $remainingBudget = $activeCycle->remaining_budget ?? 0;
        
        $monthList = $this->currentMonth();
        $currentMonth = date('F');
        
        $chartData = $this->getChartData($userId);

        return view('pages.dashboard', compact(
            'navtitle',
            'user',
            'totalEarnings',
            'totalExpenses',
            'totalSavings',
            'remainingBudget',
            'monthList',
            'currentMonth',
            'chartData'
        ));
    }

    private function getUserInfo($userId)
    {
        $sql = "SELECT full_name, payday_cutoff FROM `user` WHERE userid = ?";
        $result = DB::select($sql, [$userId]);

        return $result[0] ?? null;
    }

    private function getActiveBudgetCycle($userId)
    {
        $sql = "
            SELECT 
                cycle_id,
                cycle_name,
                total_income,
                total_expense,
                total_savings,
                remaining_budget
            FROM budget_cycles
            WHERE userid = ? AND is_active = 1
            LIMIT 1
        ";

        return DB::select($sql, [$userId])[0] ?? null;
    }
    
    private function getChartData($userId)
    {
        $sql = "
            SELECT 
                cycle_name,
                total_income,
                total_expense,
                total_savings,
                remaining_budget
            FROM budget_cycles
            WHERE userid = ?
            ORDER BY start_date ASC
            LIMIT 12
        ";
        
        return DB::select($sql, [$userId]);
    }

    private function currentMonth()
    {
        return date('F');
    }
}