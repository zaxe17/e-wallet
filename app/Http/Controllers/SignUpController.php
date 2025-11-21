<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
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
        Log::info('=== SIGNUP ATTEMPT START ===');
        Log::info('Form data received:', $request->except(['password', 'password_confirmation']));

        // Validation
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:40',
            'middle_name' => 'nullable|string|max:40',
            'last_name' => 'required|string|max:40',
            'date_of_birth' => 'required|date|before:today',
            'age' => 'required|integer|min:18|max:120',
            'sex' => 'required|in:Male,Female',
            'citizenship' => 'required|string|max:15',
            'occupation' => 'required|string|max:50',
            'username' => 'required|string|max:15|unique:user,username',
            'connected_bank' => 'required|string|max:100',
            'other_bank' => 'nullable|string|max:100',
            'phone_number' => 'required|string|max:15|unique:user,phone_number',
            'email_address' => 'required|email|max:30|unique:user,email_address',
            'address' => 'required|string|max:100',
            'id_type' => 'required|string|max:50',
            'id_number' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            Log::warning('Validation failed:', $validator->errors()->toArray());
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Log::info('Validation passed');

        try {
            // Generate password
            $plainPassword = $this->generateSecurePassword();
            Log::info('Password generated');
            
            // Prepare full name
            $fullName = trim($request->first_name . ' ' . 
                           ($request->middle_name ? $request->middle_name . ' ' : '') . 
                           $request->last_name);

            // Handle connected bank
            $connectedBank = $request->connected_bank === 'Other' 
                ? $request->other_bank 
                : $request->connected_bank;

            // Convert sex
            $sex = $request->sex === 'Male' ? 'M' : 'F';

            // Prepare data
            $userData = [
                'full_name' => $fullName,
                'date_of_birth' => $request->date_of_birth,
                'username' => $request->username,
                'age' => $request->age,
                'citizenship' => $request->citizenship,
                'address' => $request->address,
                'phone_number' => $request->phone_number,
                'email_address' => $request->email_address,
                'password' => Hash::make($plainPassword),
                'sex' => $sex,
                'budget' => 0,
                'budget_status' => 'Active',
            ];

            Log::info('Inserting user into database...', ['username' => $request->username]);

            // Insert
            $inserted = DB::table('user')->insert($userData);

            if ($inserted) {
                Log::info('User inserted successfully!');
                
                // Send email
                try {
                    Notification::route('mail', $request->email_address)
                        ->notify(new PasswordNotif($plainPassword, $request->username, $fullName));
                    Log::info('Password email sent');
                } catch (\Exception $e) {
                    Log::warning('Email failed: ' . $e->getMessage());
                }

                return redirect()->route('login.index')
                    ->with('success', 'Account created successfully! Please check your email for your password.');
            }

            Log::error('Insert returned false');
            return redirect()->back()
                ->with('error', 'Failed to create account.')
                ->withInput();

        } catch (\Illuminate\Database\QueryException $e) {
            Log::error('Database error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Database error: ' . $e->getMessage())
                ->withInput();
        } catch (\Exception $e) {
            Log::error('General error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'An error occurred: ' . $e->getMessage())
                ->withInput();
        }
    }

    private function generateSecurePassword($length = 10)
    {
        $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lowercase = 'abcdefghijklmnopqrstuvwxyz';
        $numbers = '0123456789';
        $special = '!@#$%^&*';
        
        $password = '';
        $password .= $uppercase[rand(0, strlen($uppercase) - 1)];
        $password .= $lowercase[rand(0, strlen($lowercase) - 1)];
        $password .= $numbers[rand(0, strlen($numbers) - 1)];
        $password .= $special[rand(0, strlen($special) - 1)];
        
        $allChars = $uppercase . $lowercase . $numbers . $special;
        for ($i = 4; $i < $length; $i++) {
            $password .= $allChars[rand(0, strlen($allChars) - 1)];
        }
        
        return str_shuffle($password);
    }
}