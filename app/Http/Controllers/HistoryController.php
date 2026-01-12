<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class HistoryController extends Controller
{
    public function index()
    {
        $navtitle = 'Wallet History';
        $userId = Session::get('user_id');

        $user = $this->getUserInfo($userId);
        $monthList = $this->currentMonth();
        $chartData = $this->getChartDataByMonth($userId);
        
        // Get all transactions for history table
        $rows = $this->getAllTransactions($userId);

        return view('pages.history', compact(
            'navtitle',
            'user',
            'monthList',
            'chartData',
            'rows'
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

    // FOR CHART.JS - BY MONTH
    private function getChartDataByMonth($userId)
    {
        $sql = "
            SELECT 
                MONTH(start_date) as month,
                MONTHNAME(start_date) as month_name,
                SUM(total_income) as total_income,
                SUM(total_expense) as total_expense,
                SUM(total_savings) as total_savings,
                SUM(remaining_budget) as remaining_budget
            FROM budget_cycles
            WHERE userid = ? AND YEAR(start_date) = YEAR(CURDATE())
            GROUP BY MONTH(start_date), MONTHNAME(start_date)
            ORDER BY MONTH(start_date) ASC
        ";

        return DB::select($sql, [$userId]);
    }

    private function currentMonth()
    {
        return date('F');
    }

    private function getAllTransactions($userId)
    {
        $transactions = [];

        // Get earnings
        $earnings = DB::select(
            "SELECT e.in_id, e.income_source, e.amount, e.date_received
         FROM earnings e
         JOIN budget_cycles bc ON e.cycle_id = bc.cycle_id
         WHERE bc.userid = ?
         ORDER BY e.date_received DESC",
            [$userId]
        );

        foreach ($earnings as $earning) {
            $transactions[] = [
                'id'      => $earning->in_id,
                'date'    => $earning->date_received,
                'label'   => $earning->income_source,
                'amount'  => $earning->amount,
                'type'    => 'income',
                'section' => 'EARNINGS',
                'update'  => route('earnings.update', $earning->in_id),
                'delete'  => route('earnings.delete', $earning->in_id),
            ];
        }

        // Get expenses
        $expenses = DB::select(
            "SELECT e.out_id, e.category, e.date_spent, e.amount
         FROM expenses e
         JOIN budget_cycles bc ON bc.cycle_id = e.cycle_id
         WHERE bc.userid = ?
         ORDER BY e.date_spent DESC",
            [$userId]
        );

        foreach ($expenses as $expense) {
            $transactions[] = [
                'id'      => $expense->out_id,
                'date'    => $expense->date_spent,
                'label'   => $expense->category,
                'amount'  => $expense->amount,
                'type'    => 'expense',
                'section' => 'EXPENSES',
                'update'  => route('expenses.update', $expense->out_id),
                'delete'  => route('expenses.delete', $expense->out_id),
            ];
        }

        // Get savings
        $savings = DB::select(
            "SELECT savingsno, bank, description, savings_amount, date_of_save, interest_earned
         FROM savings
         WHERE userid = ?
         ORDER BY date_of_save DESC",
            [$userId]
        );

        foreach ($savings as $saving) {
            $label = $saving->bank;
            if (!empty($saving->description)) {
                $label .= ' - ' . $saving->description;
            }
            
            $transactions[] = [
                'id'      => $saving->savingsno,
                'date'    => $saving->date_of_save,
                'label'   => $label,
                'amount'  => $saving->savings_amount + $saving->interest_earned,
                'type'    => 'savings',
                'section' => 'SAVINGS',
                'update'  => route('savings.update', $saving->savingsno),
                'delete'  => route('savings.delete', $saving->savingsno),
            ];
        }

        // Sort all transactions by date (newest first)
        usort($transactions, function ($a, $b) {
            return strtotime($b['date']) - strtotime($a['date']);
        });

        return $transactions;
    }
}