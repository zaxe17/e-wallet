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
        $userId = Session::get('user_id');

        $user = $this->getUserInfo($userId);
        $monthList = $this->currentMonth();
        
        // Get chart data by days for current month
        $chartData = $this->getChartDataByDays($userId);
        
        // Get totals
        $remainingBudget = $this->getRemainingBudget($userId);
        $budgetRemarks = $this->getBudgetRemarks($remainingBudget);
        $totalEarnings = $this->getTotalEarnings($userId);
        $totalSavings = $this->getTotalSavings($userId);
        $totalExpenses = $this->getTotalExpenses($userId);

        return view('pages.dashboard', compact(
            'navtitle',
            'user',
            'monthList',
            'chartData',
            'remainingBudget',
            'budgetRemarks',
            'totalEarnings',
            'totalSavings',
            'totalExpenses'
        ));
    }

    private function getUserInfo($userId)
    {
        $result = DB::select("SELECT full_name FROM `user` WHERE userid = ?", [$userId]);

        if (empty($result)) {
            return null;
        }

        $userRow = $result[0];
        $fullName = trim($userRow->full_name ?? '');
        if ($fullName === '') return null;

        $nameParts = explode(' ', $fullName);
        $count = count($nameParts);

        return $count > 2
            ? implode(' ', array_slice($nameParts, 0, $count - 2))
            : $nameParts[0];
    }

    private function currentMonth()
    {
        return date('F');
    }

    // Get chart data by days for current month
    private function getChartDataByDays($userId)
    {
        $currentMonth = date('m');
        $currentYear = date('Y');
        
        // Get the active cycle for current month
        $activeCycle = DB::selectOne(
            "SELECT cycle_id, remaining_budget, start_date
            FROM budget_cycles
            WHERE userid = ?
            AND MONTH(start_date) = ?
            AND YEAR(start_date) = ?
            ORDER BY is_active DESC, start_date DESC
            LIMIT 1",
            [$userId, $currentMonth, $currentYear]
        );

        if (!$activeCycle) {
            return [];
        }

        // Get daily budget progression
        $sql = "
            SELECT 
                DATE(date_spent) as date,
                (? - SUM(amount)) as remaining_budget
            FROM expenses e
            JOIN budget_cycles bc ON bc.cycle_id = e.cycle_id
            WHERE bc.cycle_id = ?
            AND MONTH(e.date_spent) = ?
            AND YEAR(e.date_spent) = ?
            GROUP BY DATE(date_spent)
            ORDER BY date_spent ASC
        ";

        $dailyExpenses = DB::select($sql, [
            $activeCycle->remaining_budget + $this->getTotalExpensesForCycle($activeCycle->cycle_id),
            $activeCycle->cycle_id,
            $currentMonth,
            $currentYear
        ]);

        // Calculate cumulative remaining budget
        $chartData = [];
        $cumulativeExpense = 0;
        $initialBudget = $activeCycle->remaining_budget + $this->getTotalExpensesForCycle($activeCycle->cycle_id);

        foreach ($dailyExpenses as $daily) {
            $chartData[] = [
                'date' => $daily->date,
                'remaining_budget' => $daily->remaining_budget
            ];
        }

        // Add current day if no expense today
        $today = date('Y-m-d');
        $hasToday = false;
        foreach ($chartData as $data) {
            if ($data['date'] === $today) {
                $hasToday = true;
                break;
            }
        }

        if (!$hasToday) {
            $chartData[] = [
                'date' => $today,
                'remaining_budget' => $activeCycle->remaining_budget
            ];
        }

        return $chartData;
    }

    private function getTotalExpensesForCycle($cycleId)
    {
        $result = DB::selectOne(
            "SELECT IFNULL(SUM(amount), 0) as total
            FROM expenses
            WHERE cycle_id = ?",
            [$cycleId]
        );

        return $result ? $result->total : 0;
    }

    private function getRemainingBudget($userId)
    {
        $result = DB::selectOne(
            "SELECT remaining_budget
            FROM budget_cycles
            WHERE userid = ?
            ORDER BY is_active DESC, start_date DESC
            LIMIT 1",
            [$userId]
        );

        return $result ? $result->remaining_budget : 0;
    }

    private function getBudgetRemarks($remainingBudget)
    {
        if ($remainingBudget > 10000) {
            return 'Good Job! You have extra money. Why not save it?';
        } elseif ($remainingBudget > 5000) {
            return 'You are doing well. Keep it up!';
        } elseif ($remainingBudget > 0) {
            return 'Be careful with your spending.';
        } else {
            return 'You have exceeded your budget!';
        }
    }

    private function getTotalEarnings($userId)
    {
        $result = DB::selectOne(
            "SELECT IFNULL(SUM(e.amount), 0) as total
            FROM earnings e
            JOIN budget_cycles bc ON e.cycle_id = bc.cycle_id
            WHERE bc.userid = ?
            AND bc.is_active = 1",
            [$userId]
        );

        return $result ? $result->total : 0;
    }

    private function getTotalSavings($userId)
    {
        $result = DB::selectOne(
            "SELECT IFNULL(SUM(savings_amount + interest_earned), 0) as total
            FROM savings
            WHERE userid = ?",
            [$userId]
        );

        return $result ? $result->total : 0;
    }

    private function getTotalExpenses($userId)
    {
        $result = DB::selectOne(
            "SELECT IFNULL(SUM(e.amount), 0) as total
            FROM expenses e
            JOIN budget_cycles bc ON e.cycle_id = bc.cycle_id
            WHERE bc.userid = ?
            AND bc.is_active = 1",
            [$userId]
        );

        return $result ? $result->total : 0;
    }
}