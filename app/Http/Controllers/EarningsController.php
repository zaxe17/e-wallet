<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class EarningsController extends Controller
{
    public function index() {
        $navtitle = 'Earnings';
        
        // Get user_id from session
        $userId = Session::get('user_id');
        
        // Get total earnings using raw SQL
        $totalSql = "SELECT IFNULL(SUM(amount), 0) as total_earnings FROM earnings WHERE in_id = ?";
        $totalResult = DB::select($totalSql, [$userId]);
        $totalEarnings = $totalResult[0]->total_earnings;
        
        // Get all earnings records using raw SQL
        $earningsSql = "
            SELECT in_id, income_source, date_received, amount 
            FROM earnings 
            WHERE in_id = ? 
            ORDER BY date_received DESC, in_id DESC
        ";
        $earnings = DB::select($earningsSql, [$userId]);
        
        return view('pages.earnings', compact('navtitle', 'totalEarnings', 'earnings'));
    }
}