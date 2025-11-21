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

    private function generateUserId()
    {
        $lastUser = DB::table('user')->orderBy('userid', 'desc')->first(); 
        if (!$lastUser) return 'PN-000001';
        $num = intval(substr($lastUser->userid, 3)) + 1;
        return 'PN-' . str_pad($num, 6, '0', STR_PAD_LEFT);
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:40',
            'middle_name' => 'nullable|string|max:40',
            'last_name' => 'required|string|max:40',
            'date_of_birth' => 'required|date|before:today',
            'age' => 'required|integer|min:18|max:120',
            'sex' => 'required|in:Male,Female',
            'citizenship' => 'required|string|max:15',
            'username' => 'required|string|max:15|unique:user,username',
            'phone_number' => 'required|string|max:15|unique:user,phone_number',
            'email_address' => 'required|email|max:30|unique:user,email_address',
            'address' => 'required|string|max:100',
        ]);

        $userId = $this->generateUserId();
        $password = $this->generateSecurePassword();
        $hashedPassword = Hash::make($password);
        $fullName = trim($request->first_name . ' ' . ($request->middle_name ? $request->middle_name . ' ' : '') . $request->last_name);
        $sex = $request->sex === 'Male' ? 'M' : 'F';

        $sql = "
                INSERT INTO user 
                (userid, full_name, date_of_birth, username, age, citizenship, address, phone_number, 
                 email_address, password, sex, budget, budget_status)
                VALUES 
                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ";

            $inserted = DB::insert($sql, [
                $userId,
                $fullName,
                $request->date_of_birth,
                $request->username,
                $request->age,
                $request->citizenship,
                $request->address,
                $request->phone_number,
                $request->email_address,
                $hashedPassword,
                $sex,
                0,
                'Active'
            ]);

        if (!$inserted) {
            Log::error("Failed to insert user into database via raw SQL for user ID: {$userId}");
        }

        $mailData = [
            'name' => $fullName,
            'username' => $request->username,
            'password' => $password,
        ];

        try {
            Notification::route('mail', $request->email_address)
                ->notify(new PasswordNotif($mailData));
            Log::info("Password email sent successfully to {$request->email_address}");
        } catch (\Exception $e) {
            Log::warning("Failed to send email to {$request->email_address}: " . $e->getMessage());
        }

        return redirect()->route('login.form')->with('success', 'Account created successfully! Check your email for the password.');
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