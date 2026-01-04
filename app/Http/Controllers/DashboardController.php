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
        $budgetRemarks   = $activeCycle->budget_remarks ?? null;

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
            'chartData',
            'budgetRemarks'
        ));
    }

    private function getUserInfo($userId)
    {
        // Fetch the user row
        $result = DB::select("SELECT full_name FROM `user` WHERE userid = ?", [$userId]);

        if (empty($result)) {
            return null; // user not found
        }

        // DB::select returns array of stdClass objects
        $userRow = $result[0];

        // Ensure full_name exists
        $fullName = trim($userRow->full_name ?? '');
        if ($fullName === '') return null;

        // Split name into parts
        $nameParts = explode(' ', $fullName);
        $count = count($nameParts);

        // Return either first part or truncated name
        return $count > 2
            ? implode(' ', array_slice($nameParts, 0, $count - 2))
            : $nameParts[0];
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
                remaining_budget,
                budget_remarks
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
