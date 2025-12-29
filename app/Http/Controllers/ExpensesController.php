<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ExpensesController extends Controller
{
    public function index()
    {
        $navtitle = 'Expenses';
        $userId = Session::get('user_id');

        $totalSql = "
            SELECT total_expense AS total_expenses
            FROM budget_cycles
            WHERE userid = ?
        ";

        $totalResult = DB::select($totalSql, [$userId]);
        $totalExpenses = $totalResult[0]->total_expenses;

        $expensesSql = "
            SELECT e.out_id, e.category, e.date_spent, e.amount 
            FROM expenses e
            JOIN budget_cycles bc ON bc.cycle_id = e.cycle_id
            WHERE bc.userid = ?
            ORDER BY date_spent DESC, out_id DESC
        ";
        
        $expenses = DB::select($expensesSql, [$userId]);

        return view('pages.expenses', compact('navtitle', 'totalExpenses', 'expenses'));
    }
}
