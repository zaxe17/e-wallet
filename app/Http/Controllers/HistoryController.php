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
        $chartData = $this->getChartData($userId);

        return view('pages.history', compact(
            'navtitle',
            'user',
            'monthList',
            'chartData',
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

    // FOR CHART.JS
    private function getChartData($userId)
    {
        $sql = "
            SELECT 
                cycle_name,
                total_income,
                total_expense,
                total_savings,
                remaining_budget
            FROM budget_cycles
            WHERE userid = ?
            ORDER BY start_date ASC
            LIMIT 12
        ";

        return DB::select($sql, [$userId]);
    }

    private function currentMonth()
    {
        return date('F');
    }
}
