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
        $monthlyBudget = $this->getMonthlyBudget($userId);

        // Get all transactions for history table
        $rows = $this->getAllTransactions($userId);

        return view('pages.history', compact(
            'navtitle',
            'user',
            'monthList',
            'monthlyBudget',
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
    private function getMonthlyBudget($userId)
    {
        return DB::select("
            SELECT 
                YEAR(start_date) AS year,
                MONTH(start_date) AS month,
                MONTHNAME(start_date) AS month_name,
                SUM(remaining_budget) AS remaining_budget
            FROM budget_cycles
            WHERE userid = ?
            GROUP BY YEAR(start_date), MONTH(start_date), MONTHNAME(start_date)
            ORDER BY YEAR(start_date), MONTH(start_date)
        ", [$userId]);
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

        // Get savings transactions (deposits and withdrawals)
        $savingsTransactions = DB::select(
            "SELECT 
                st.trans_id,
                st.trans_type,
                st.trans_date,
                st.amount,
                s.bank,
                s.description,
                s.savingsno
            FROM savings_transactions st
            JOIN savings s ON st.savingsno = s.savingsno
            WHERE s.userid = ?
            ORDER BY st.trans_date DESC",
            [$userId]
        );

        foreach ($savingsTransactions as $trans) {
            $label = $trans->bank;
            if (!empty($trans->description)) {
                $label .= ' - ' . $trans->description;
            }

            // Add transaction type to label
            $transLabel = $trans->trans_type === 'DEPOSIT' ? 'Deposit: ' : 'Withdrawal: ';
            $label = $transLabel . $label;

            $transactions[] = [
                'id'      => $trans->trans_id,
                'date'    => $trans->trans_date,
                'label'   => $label,
                'amount'  => $trans->amount,
                'type'    => $trans->trans_type === 'DEPOSIT' ? 'savings' : 'withdrawal',
                'section' => 'SAVINGS',
                'update'  => null, // Transactions can't be updated individually
                'delete'  => null, // Transactions can't be deleted individually
            ];
        }

        // Sort all transactions by date (newest first)
        usort($transactions, function ($a, $b) {
            return strtotime($b['date']) - strtotime($a['date']);
        });

        return $transactions;
    }
}
