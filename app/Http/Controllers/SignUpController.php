<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;
use App\Notifications\PasswordNotif;

class SignupController extends Controller
{
    public function index()
    {
        return view('pages.signup');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name'     => 'required|string|max:40',
            'middle_name'    => 'nullable|string|max:40',
            'last_name'      => 'required|string|max:40',
            'date_of_birth'  => 'required|date|before:today',
            'age'            => 'required|integer|min:18|max:120',
            'sex'            => 'required|in:Male,Female',
            'citizenship'    => 'required|string|max:15',
            'username'       => 'required|string|max:15|unique:user,username',
            'phone_number'   => 'required|string|max:15|unique:user,phone_number',
            'email_address'  => 'required|email|max:30|unique:user,email_address',
            'address'        => 'required|string|max:100',
        ]);

        DB::beginTransaction();

        try {
            $userId   = $this->generateUserId();
            $password = $this->generateSecurePassword();

            $fullName = trim(
                $request->first_name . ' ' .
                ($request->middle_name ? $request->middle_name . ' ' : '') .
                $request->last_name
            );

            $sex     = $request->sex === 'Male' ? 'M' : 'F';
            $passkey = str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);

            DB::insert("
                INSERT INTO user
                (userid, full_name, date_of_birth, username, age, citizenship,
                 address, phone_number, email_address, password, passkey, sex, date_registered)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ", [
                $userId,
                $fullName,
                $request->date_of_birth,
                $request->username,
                $request->age,
                $request->citizenship,
                $request->address,
                $request->phone_number,
                $request->email_address,
                Hash::make($password),
                $passkey,
                $sex,
                now()
            ]);

            // ✅ CREATE INITIAL BUDGET CYCLE
            $this->createInitialBudgetCycle($userId);

            DB::commit();

            // SEND EMAIL
            Notification::route('mail', $request->email_address)
                ->notify(new PasswordNotif([
                    'name'     => $fullName,
                    'username' => $request->username,
                    'password' => $password,
                ]));

            return redirect()
                ->route('login.form')
                ->with('success', 'Account created successfully! Check your email.');

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Signup failed: ' . $e->getMessage());

            return back()->with('error', 'Registration failed.');
        }
    }

    private function generateUserId()
    {
        $last = DB::table('user')->orderBy('userid', 'desc')->first();
        if (!$last) return 'PN-000001';

        $num = intval(substr($last->userid, 3)) + 1;
        return 'PN-' . str_pad($num, 6, '0', STR_PAD_LEFT);
    }

    private function generateCycleId()
    {
        $last = DB::table('budget_cycles')->orderBy('cycle_id', 'desc')->first();
        if (!$last) return 'CYC-000001';

        $num = intval(substr($last->cycle_id, 4)) + 1;
        return 'CYC-' . str_pad($num, 6, '0', STR_PAD_LEFT);
    }

    private function createInitialBudgetCycle($userId)
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
            now()->startOfMonth()->toDateString(),
            now()->endOfMonth()->toDateString(),
            now()->format('F Y')
        ]);
    }

    private function generateSecurePassword($length = 10)
    {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*';
        $password = '';
        for ($i = 0; $i < $length; $i++) {
            $password .= $chars[random_int(0, strlen($chars) - 1)];
        }
        return $password;
    }
}
