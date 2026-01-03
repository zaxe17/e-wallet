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
        
        // Get the latest budget cycle for the user
        $sql = "SELECT cycle_id, total_income FROM budget_cycles WHERE userid = ? ORDER BY start_date DESC LIMIT 1";
        $activeCycle = DB::select($sql, [$userId]);
        
        $totalEarnings = $activeCycle ? $activeCycle[0]->total_income : 0;
        $cycleId = $activeCycle ? $activeCycle[0]->cycle_id : null;
        
        // Get all earnings for the cycle
        $earnings = [];
        if ($cycleId) {
            $sql = "SELECT in_id, income_source, amount, date_received FROM earnings WHERE cycle_id = ? ORDER BY date_received DESC";
            $earnings = DB::select($sql, [$cycleId]);
        }
        
        return view('pages.earnings', compact('navtitle', 'totalEarnings', 'earnings', 'cycleId'));
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
        $sql = "SELECT cycle_id FROM budget_cycles WHERE userid = ? ORDER BY start_date DESC LIMIT 1";
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
        
        return redirect()->route('earnings.index')->with('success', 'Earnings record added successfully.');
    }
    
    public function deleteEarnings($in_id)
    {
        $userId = Session::get('user_id');
        
        // Verify ownership before deleting
        $sql = "SELECT e.in_id FROM earnings e JOIN budget_cycles bc ON bc.cycle_id = e.cycle_id WHERE e.in_id = ? AND bc.userid = ?";
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
        
        return redirect()->route('earnings.index')->with('success', 'Earnings record deleted successfully.');
    }
}