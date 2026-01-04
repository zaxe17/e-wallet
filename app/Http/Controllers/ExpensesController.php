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
        $totalExpenses = $totalResult[0]->total_expenses ?? 0;

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

    public function store(Request $request)
    {
        $userId = Session::get('user_id');

        $request->validate([
            'date_spent' => 'required|date',
            'category' => 'required|string|max:50',
            'amount' => 'required|numeric|min:0.01',
        ]);

        // Get the active budget cycle for the user
        $cycleResult = DB::select("
            SELECT cycle_id
            FROM budget_cycles
            WHERE userid = ? AND is_active = 1
            LIMIT 1
        ", [$userId]);

        if (!$cycleResult) {
            return redirect()->route('expenses.index')->with('error', 'No active budget cycle found.');
        }

        $cycle_id = $cycleResult[0]->cycle_id;

        DB::insert("
            INSERT INTO expenses (cycle_id, category, amount, date_spent)
            VALUES (?, ?, ?, ?)
        ", [$cycle_id, $request->category, $request->amount, $request->date_spent]);

        return redirect()->route('expenses.index')->with('success', 'Added successfully.');
    }

    public function updateExpenses(Request $request, $out_id)
    {
        // validation
        $request->validate([
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
        ]);

        DB::update(
            "UPDATE expenses 
            SET category = ?, amount = ?
            WHERE out_id = ?",
            [
                $request->category,
                $request->amount,
                $out_id
            ]
        );

        return redirect()->route('expenses.index')->with('success', 'Updated successfully.');
    }

    public function deleteExpenses($out_id)
    {
        $userId = Session::get('user_id');

        $expenses = DB::select("
            SELECT e.cycle_id, e.amount
            FROM expenses e
            JOIN budget_cycles bc ON bc.cycle_id = e.cycle_id
            WHERE e.out_id = ? AND bc.userid = ?
        ", [$out_id, $userId]);

        if (!$expenses) {
            return redirect()->route('expenses.index')->with('error', 'Expenses record not found.');
        }

        $cycle_id = $expenses[0]->cycle_id;

        DB::delete("
            DELETE FROM expenses
            WHERE out_id = ? AND cycle_id = ?
        ", [$out_id, $cycle_id]);

        return redirect()->route('expenses.index')->with('success', 'Deleted successfully.');
    }
}