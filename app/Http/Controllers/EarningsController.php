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
}
