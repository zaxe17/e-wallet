<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index()
    {
        $navtitle = 'Dashboard';
        $userId = Session::get('user_id');

        $user = $this->getUserInfo($userId);
        $monthList = $this->currentMonth();
        $dailyEarnings = $this->getDailyNetAmount($userId);

        $remainingBudget = $this->getRemainingBudget($userId);
        $budgetRemarks   = $this->getBudgetRemarks($userId);
        $totalEarnings   = $this->getTotalEarnings($userId);
        $totalSavings    = $this->getTotalSavings($userId);
        $totalExpenses   = $this->getTotalExpenses($userId);

        // 🔥 CHECK IF NEED ROLLOVER
        $showRollover = $this->checkIfNeedRollover($userId);

        // 🔥 CREATE NEW CYCLE ONLY IF NO ROLLOVER PENDING
        if (!$showRollover) {
            $this->createMonthlyCycleIfNeeded($userId);
        }

        return view('pages.dashboard', compact(
            'navtitle',
            'user',
            'monthList',
            'dailyEarnings',
            'remainingBudget',
            'budgetRemarks',
            'totalEarnings',
            'totalSavings',
            'totalExpenses',
            'showRollover'
        ));
    }

    // ===================== USER INFO =====================
    private function getUserInfo($userId)
    {
        $result = DB::select("SELECT full_name FROM `user` WHERE userid = ?", [$userId]);
        if (empty($result)) return null;

        $fullName = trim($result[0]->full_name ?? '');
        if ($fullName === '') return null;

        $nameParts = explode(' ', $fullName);
        return count($nameParts) > 2
            ? implode(' ', array_slice($nameParts, 0, count($nameParts) - 2))
            : $nameParts[0];
    }

    // ===================== ROLLOVER LOGIC =====================
    private function checkIfNeedRollover($userId)
    {
        return DB::table('budget_cycles')
            ->where('userid', $userId)
            ->where('is_active', 1)
            ->whereRaw('end_date < CURRENT_DATE()')
            ->exists();
    }

    // NEGATIVE / ZERO: Close old cycle only
    public function closeCycleOnly()
    {
        $userId = Session::get('user_id');

        $cycle = DB::table('budget_cycles')
            ->where('userid', $userId)
            ->where('is_active', 1)
            ->first();

        if (!$cycle) {
            return redirect()->route('dashboard.index');
        }

        DB::table('budget_cycles')
            ->where('cycle_id', $cycle->cycle_id)
            ->update([
                'is_active' => 0,
                'rollover_status' => 'NONE',
                'rollover_amount' => 0
            ]);


        // Start new cycle
        $this->createMonthlyCycleIfNeeded($userId);

        return redirect()->route('dashboard.index')->with('success', 'Previous cycle closed. New cycle started.');
    }

    // POSITIVE: Process rollover into savings or expense
    public function processRollover(Request $request)
    {
        $userId    = Session::get('user_id');
        $decision  = $request->input('decision');
        $savingsNo = $request->input('savingsno');

        Log::info('Rollover Input:', [
            'user_id'    => $userId,
            'decision'   => $decision,
            'savings_no' => $savingsNo
        ]);

        if ($decision === 'SAVED' && empty($savingsNo)) {
            $savingsNo = $this->generateSavingsNo();
            Log::info("Auto-generated savings number for rollover: {$savingsNo}");
        }

        // CALL PROCEDURE ONLY FOR POSITIVE ROLLOVER
        DB::statement("CALL CloseAndStartNewCycle(?, ?, ?)", [
            $userId,
            $decision,
            $savingsNo
        ]);

        return redirect()->route('dashboard.index')->with('success', 'Rollover processed successfully.');
    }

    // ===================== DAILY NET =====================
    private function getDailyNetAmount($userId)
    {
        $cycle = DB::selectOne("SELECT cycle_id FROM budget_cycles WHERE userid = ? AND is_active = 1 LIMIT 1", [$userId]);
        if (!$cycle) return [];

        $cycleId = $cycle->cycle_id;
        $earnings = $this->getDailyEarningsRaw($cycleId);
        $expenses = $this->getDailyExpensesRaw($cycleId);
        $savings  = $this->getDailySavingsRaw($userId);

        $daily = [];
        foreach ($earnings as $e) $daily[$e->day]['earnings'] = $e->total;
        foreach ($expenses as $x) $daily[$x->day]['expenses'] = $x->total;
        foreach ($savings as $s) $daily[$s->day]['savings'] = $s->total;

        $result = [];
        foreach ($daily as $day => $data) {
            $earn = $data['earnings'] ?? 0;
            $save = $data['savings'] ?? 0;
            $exp  = $data['expenses'] ?? 0;

            $result[] = (object)[
                'day' => $day,
                'net_total' => $earn - ($save + $exp)
            ];
        }

        usort($result, fn($a, $b) => strcmp($a->day, $b->day));
        return $result;
    }

    private function getDailySavingsRaw($userId)
    {
        return DB::select("
            SELECT DATE(date_of_save) AS day, SUM(savings_amount) AS total
            FROM savings
            WHERE userid = ? AND MONTH(date_of_save) = MONTH(CURRENT_DATE()) AND YEAR(date_of_save) = YEAR(CURRENT_DATE())
            GROUP BY DATE(date_of_save)
        ", [$userId]);
    }

    private function getDailyExpensesRaw($cycleId)
    {
        return DB::select("
            SELECT DATE(date_spent) AS day, SUM(amount) AS total
            FROM expenses
            WHERE cycle_id = ? AND MONTH(date_spent) = MONTH(CURRENT_DATE()) AND YEAR(date_spent) = YEAR(CURRENT_DATE())
            GROUP BY DATE(date_spent)
        ", [$cycleId]);
    }

    private function getDailyEarningsRaw($cycleId)
    {
        return DB::select("
            SELECT DATE(date_received) AS day, SUM(amount) AS total
            FROM earnings
            WHERE cycle_id = ? AND MONTH(date_received) = MONTH(CURRENT_DATE()) AND YEAR(date_received) = YEAR(CURRENT_DATE())
            GROUP BY DATE(date_received)
        ", [$cycleId]);
    }

    private function currentMonth()
    {
        return date('F');
    }

    // ===================== TOTALS =====================
    private function getRemainingBudget($userId)
    {
        $result = DB::selectOne("SELECT remaining_budget FROM budget_cycles WHERE userid = ? AND is_active = 1 LIMIT 1", [$userId]);
        return $result ? $result->remaining_budget : 0;
    }

    private function getBudgetRemarks($userid)
    {
        $sql = "
        SELECT budget_remarks
        FROM budget_cycles
        WHERE userid = ? AND is_active = 1
        LIMIT 1
        ";

        return DB::selectOne($sql, [$userid])->budget_remarks ?? null;
    }

    private function getTotalEarnings($userId)
    {
        $result = DB::selectOne("
            SELECT IFNULL(SUM(e.amount),0) as total
            FROM earnings e
            JOIN budget_cycles bc ON e.cycle_id = bc.cycle_id
            WHERE bc.userid = ? AND bc.is_active = 1
        ", [$userId]);
        return $result ? $result->total : 0;
    }

    private function getTotalSavings($userId)
    {
        $result = DB::selectOne("
            SELECT IFNULL(SUM(savings_amount + interest_earned),0) as total
            FROM savings
            WHERE userid = ?
        ", [$userId]);
        return $result ? $result->total : 0;
    }

    private function getTotalExpenses($userId)
    {
        $result = DB::selectOne("
            SELECT IFNULL(SUM(e.amount),0) as total
            FROM expenses e
            JOIN budget_cycles bc ON e.cycle_id = bc.cycle_id
            WHERE bc.userid = ? AND bc.is_active = 1
        ", [$userId]);
        return $result ? $result->total : 0;
    }

    // ===================== CYCLE CREATION =====================
    private function generateCycleId()
    {
        $last = DB::table('budget_cycles')->orderBy('cycle_id', 'desc')->first();
        if (!$last) return 'CYC-000001';
        $num = intval(substr($last->cycle_id, 4)) + 1;
        return 'CYC-' . str_pad($num, 6, '0', STR_PAD_LEFT);
    }

    private function createMonthlyCycleIfNeeded($userId)
    {
        $monthStart = now()->startOfMonth()->toDateString();
        $monthEnd   = now()->endOfMonth()->toDateString();

        $exists = DB::table('budget_cycles')
            ->where('userid', $userId)
            ->where('start_date', $monthStart)
            ->exists();

        if (!$exists) {
            DB::table('budget_cycles')->where('userid', $userId)->update(['is_active' => 0]);

            DB::insert("
                INSERT INTO budget_cycles
                (cycle_id, userid, start_date, end_date, cycle_name, total_income, total_expense, total_savings, budget_remarks, is_active, rollover_amount)
                VALUES (?, ?, ?, ?, ?, 0, 0, 0, NULL, 1, 0)
            ", [
                $this->generateCycleId(),
                $userId,
                $monthStart,
                $monthEnd,
                now()->format('F Y')
            ]);
        }
    }

    // ===================== SAVINGS NUMBER GENERATOR =====================
    private function generateSavingsNo()
    {
        $last = DB::table('savings')
            ->select('savingsno')
            ->orderBy('savingsno', 'desc')
            ->first();

        if (!$last || empty($last->savingsno)) {
            return 'SAVE-000001';
        }

        $num = intval(substr($last->savingsno, 5)) + 1;
        return 'SAVE-' . str_pad($num, 6, '0', STR_PAD_LEFT);
    }
}
