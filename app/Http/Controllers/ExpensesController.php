<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ExpensesController extends Controller
{
    public function index() {
        $navtitle = 'Expenses';
        
        // Get user_id from session
        $userId = Session::get('user_id');
        
        // Get total expenses using raw SQL
        $totalSql = "SELECT IFNULL(SUM(cashout_amount), 0) as total_expenses FROM expenses WHERE userid = ?";
        $totalResult = DB::select($totalSql, [$userId]);
        $totalExpenses = $totalResult[0]->total_expenses;
        
        // Get all expenses records using raw SQL
        $expensesSql = "
            SELECT out_id, category_expense, date_out, cashout_amount 
            FROM expenses 
            WHERE userid = ? 
            ORDER BY date_out DESC, out_id DESC
        ";
        $expenses = DB::select($expensesSql, [$userId]);
        
        return view('pages.expenses', compact('navtitle', 'totalExpenses', 'expenses'));
    }
}