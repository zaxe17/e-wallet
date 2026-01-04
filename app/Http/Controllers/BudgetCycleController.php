<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class BudgetCycleController extends Controller
{
    /**
     * Check if current month has a budget cycle, create if not
     */
    public function checkAndCreateCycle()
    {
        $userId = Session::get('user_id');

        if (!$userId) {
            return redirect()->route('login.form');
        }

        $now = now();
        $startOfMonth = $now->startOfMonth()->toDateString();
        $endOfMonth   = $now->endOfMonth()->toDateString();
        $cycleName    = $now->format('F Y');

        // Get active cycle
        $activeCycle = DB::select("
        SELECT cycle_id, start_date
        FROM budget_cycles
        WHERE userid = ? AND is_active = 1
        LIMIT 1
    ", [$userId]);

        // If there is NO active cycle → create one
        if (empty($activeCycle)) {
            $this->createCycle($userId, $startOfMonth, $endOfMonth, $cycleName);
            return redirect()->route('dashboard.index');
        }

        // If active cycle is NOT current month → rollover
        if ($activeCycle[0]->start_date !== $startOfMonth) {

            // Deactivate old cycle
            DB::update("
            UPDATE budget_cycles
            SET is_active = 0
            WHERE cycle_id = ?
        ", [$activeCycle[0]->cycle_id]);

            // Create new cycle
            $this->createCycle($userId, $startOfMonth, $endOfMonth, $cycleName);
        }

        return redirect()->route('dashboard.index');
    }

    /**
     * Generate a unique cycle ID
     */
    private function generateCycleId()
    {
        $last = DB::select("SELECT cycle_id FROM budget_cycles ORDER BY id DESC LIMIT 1");

        if (empty($last)) {
            return 'CYCLE-000001';
        }

        $lastId = $last[0]->cycle_id;
        $num = (int) str_replace('CYCLE-', '', $lastId) + 1;

        return 'CYCLE-' . str_pad($num, 6, '0', STR_PAD_LEFT);
    }

    private function createCycle($userId, $start, $end, $name)
    {
        DB::insert("
        INSERT INTO budget_cycles
        (cycle_id, userid, start_date, end_date, cycle_name,
         total_income, total_expense, total_savings,
         budget_remarks, is_active, rollover_amount)
        VALUES (?, ?, ?, ?, ?, 0, 0, 0, NULL, 1, 0)
    ", [
            $this->generateCycleId(),
            $userId,
            $start,
            $end,
            $name
        ]);
    }
}
