<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ExpensesController extends Controller
{
    public function index(Request $request)
    {
        $navtitle = 'Expenses';
        $userId = Session::get('user_id');
        $monthData = $this->showTotalExpensesByMonth($request);

        $activeCycle = DB::selectOne(
            "SELECT cycle_id, total_expense
            FROM budget_cycles
            WHERE userid = ?
            ORDER BY is_active DESC, start_date DESC
            LIMIT 1",
            [$userId]
        );

        $totalExpenses = $monthData['totalExpenses']
            ?? ($activeCycle ? $activeCycle->total_expense : 0);

        $cycleId = $activeCycle ? $activeCycle->cycle_id : null;

        $expenses = DB::select(
            "SELECT e.out_id, e.category, e.date_spent, e.amount
         FROM expenses e
         JOIN budget_cycles bc ON bc.cycle_id = e.cycle_id
         WHERE bc.userid = ?
         ORDER BY e.date_spent DESC, e.out_id DESC",
            [$userId]
        );

        $expensesTable = collect($expenses)->map(fn($e) => [
            'id'     => $e->out_id,
            'date'   => $e->date_spent,
            'label'  => $e->category,
            'amount' => $e->amount,
            'type'   => 'expense',
            'update' => route('expenses.update', $e->out_id),
            'delete' => route('expenses.delete', $e->out_id),
        ]);

        return view('pages.expenses', [
            'navtitle' => $navtitle,
            'totalExpenses' => $totalExpenses,
            'expenses' => $expenses,
            'expensesTable' => $expensesTable,
            'months' => $monthData['months'],
            'currentMonth' => $monthData['currentMonth'],
        ]);
    }

    private function showTotalExpensesByMonth(Request $request)
    {
        $userId = Session::get('user_id');
        $months = $this->getMonths();
        $currentMonth = $request->month ?? date('m');

        $cycle = DB::selectOne(
            "SELECT total_expense
         FROM budget_cycles
         WHERE userid = ?
         AND MONTH(start_date) = ?
         ORDER BY start_date DESC
         LIMIT 1",
            [$userId, $currentMonth]
        );

        return [
            'months' => $months,
            'currentMonth' => $currentMonth,
            'totalExpenses' => $cycle ? $cycle->total_expense : 0,
        ];
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
            WHERE e.out_id = ? AND bc.userid = ? AND bc.is_active = 1
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

    private function getMonths()
    {
        return [
            '01' => 'January',
            '02' => 'February',
            '03' => 'March',
            '04' => 'April',
            '05' => 'May',
            '06' => 'June',
            '07' => 'July',
            '08' => 'August',
            '09' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December',
        ];
    }
}
