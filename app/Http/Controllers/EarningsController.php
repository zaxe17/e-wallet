<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class EarningsController extends Controller
{
    public function index()
    {
        $navtitle = 'Earnings';
        $userId = Session::get('user_id');

        $totalSql = "
            SELECT total_income AS total_earnings
            FROM budget_cycles
            WHERE userid = ?
        ";

        $totalEarnings = DB::select($totalSql, [$userId])[0]->total_earnings;

        $earningsSql = "
            SELECT e.in_id, e.income_source, e.amount, e.date_received
            FROM earnings e
            JOIN budget_cycles bc ON bc.cycle_id = e.cycle_id
            WHERE bc.userid = ?
            ORDER BY e.date_received DESC
        ";

        $earnings = DB::select($earningsSql, [$userId]);

        return view('pages.earnings', compact('navtitle', 'totalEarnings', 'earnings'));
    }

    public function deleteEarnings($in_id)
    {
        $userId = Session::get('user_id');

        $earnings = DB::select("
            SELECT e.cycle_id
            FROM earnings e
            JOIN budget_cycles bc ON bc.cycle_id = e.cycle_id
            WHERE e.in_id = ? AND bc.userid = ?
        ", [$in_id, $userId]);

        if (!$earnings) {
            return redirect()->route('earnings.index')->with('error', 'Earnings record not found.');
        }

        $cycle_id = $earnings[0]->cycle_id;

        DB::delete("
            DELETE FROM earnings
            WHERE in_id = ? AND cycle_id = ?
        ", [$in_id, $cycle_id]);

        return redirect()->route('earnings.index')->with('success', 'Earnings record deleted.');
    }
}
