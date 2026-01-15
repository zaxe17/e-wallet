<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class EarningsController extends Controller
{
    public function index(Request $request)
    {
        $navtitle = 'Earnings';
        $userId = Session::get('user_id');
        $monthData = $this->showTotalEarningsByMonth($request);

        $activeCycle = DB::selectOne(
            "SELECT cycle_id, total_income
            FROM budget_cycles
            WHERE userid = ?
            ORDER BY is_active DESC, start_date DESC
            LIMIT 1",
            [$userId]
        );

        $totalEarnings = $monthData['totalEarnings'] ?? ($activeCycle ? $activeCycle->total_income : 0);

        $cycleId = $activeCycle ? $activeCycle->cycle_id : null;

        $earnings = DB::select(
            "SELECT e.in_id, e.income_source, e.amount, e.date_received,
                bc.cycle_name, bc.is_active
         FROM earnings e
         JOIN budget_cycles bc ON e.cycle_id = bc.cycle_id
         WHERE bc.userid = ?
         ORDER BY e.date_received DESC, e.in_id DESC",
            [$userId]
        );

        $earningsTable = collect($earnings)->map(fn($e) => [
            'id'     => $e->in_id,
            'date'   => $e->date_received,
            'label'  => $e->income_source,
            'amount' => $e->amount,
            'type'   => 'income',
            'update' => route('earnings.update', $e->in_id),
            'delete' => route('earnings.delete', $e->in_id),
        ]);

        return view('pages.earnings', [
            'navtitle' => $navtitle,
            'totalEarnings' => $totalEarnings,
            'earnings' => $earnings,
            'earningsTable' => $earningsTable,
            'cycleId' => $cycleId,
            'months' => $monthData['months'],
            'currentMonth' => $monthData['currentMonth'],
        ]);
    }

    private function showTotalEarningsByMonth(Request $request)
    {
        $userId = Session::get('user_id');
        $months = $this->getMonths();
        $currentMonth = $request->month ?? date('m');

        $cycle = DB::selectOne(
            "SELECT total_income
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
            'totalEarnings' => $cycle ? $cycle->total_income : 0,
        ];
    }

    public function store(Request $request)
    {
        $userId = Session::get('user_id');

        // Validate input
        $request->validate([
            'date_received' => 'required|date',
            'income_source' => 'required|string|max:50',
            'amount' => 'required|numeric|min:0.01'
        ]);

        // Get latest cycle for the user
        $sql = "SELECT cycle_id FROM budget_cycles WHERE userid = ? AND is_active = 1 ORDER BY start_date DESC LIMIT 1";
        $activeCycle = DB::select($sql, [$userId]);

        if (!$activeCycle) {
            return redirect()->route('earnings.index')->with('error', 'No budget cycle found. Please create a budget cycle first.');
        }

        $cycleId = $activeCycle[0]->cycle_id;

        // Insert earnings record
        $sql = "INSERT INTO earnings (cycle_id, income_source, amount, date_received) VALUES (?, ?, ?, ?)";
        $inserted = DB::insert($sql, [
            $cycleId,
            $request->income_source,
            $request->amount,
            $request->date_received
        ]);

        if (!$inserted) {
            return redirect()->route('earnings.index')->with('error', 'Failed to add earnings record.');
        }

        return redirect()->route('earnings.index')->with('success', 'Added successfully.');
    }

    public function updateEarnings(Request $request, $in_id)
    {
        // validation
        $request->validate([
            'income_source' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
        ]);

        DB::update(
            "UPDATE earnings 
            SET income_source = ?, amount = ?
            WHERE in_id = ?",
            [
                $request->income_source,
                $request->amount,
                $in_id
            ]
        );

        return redirect()->route('earnings.index')->with('success', 'Updated successfully.');
    }

    public function deleteEarnings($in_id)
    {
        $userId = Session::get('user_id');

        // Verify ownership before deleting
        $sql = "SELECT e.in_id FROM earnings e JOIN budget_cycles bc ON bc.cycle_id = e.cycle_id WHERE e.in_id = ? AND bc.userid = ? AND bc.is_active = 1";
        $earnings = DB::select($sql, [$in_id, $userId]);

        if (!$earnings) {
            return redirect()->route('earnings.index')->with('error', 'Earnings record not found.');
        }

        // Delete earnings record
        $sql = "DELETE FROM earnings WHERE in_id = ?";
        $deleted = DB::delete($sql, [$in_id]);

        if (!$deleted) {
            return redirect()->route('earnings.index')->with('error', 'Failed to delete earnings record.');
        }

        return redirect()->route('earnings.index')->with('success', 'Deleted successfully.');
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
