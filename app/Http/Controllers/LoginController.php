<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /**
     * Display the login form.
     */
    public function index()
    {
        return view('pages.login');
    }

    /**
     * Handle user login.
     */
    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'email_username' => 'required|string',
            'password' => 'required|string',
        ]);

        try {
            // Find user by email or username
            $user = DB::table('user')
                ->where('email_address', $request->email_username)
                ->orWhere('username', $request->email_username)
                ->first();

            // Check if user exists and password is correct
            if ($user && Hash::check($request->password, $user->password)) {
                // Store user information in session
                Session::put('user_id', $user->userid);
                Session::put('username', $user->username);
                Session::put('full_name', $user->full_name);
                Session::put('email', $user->email_address);

                return redirect()->route('dashboard.index')
                    ->with('success', 'Welcome back, ' . $user->full_name . '!');
            } else {
                return redirect()->back()
                    ->with('error', 'Invalid email/username or password.')
                    ->withInput($request->only('email_username'));
            }

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Login failed. Please try again.')
                ->withInput($request->only('email_username'));
        }
    }

    /**
     * Handle user logout.
     */
    public function destroy()
    {
        Session::flush();
        return redirect()->route('loginForm')
            ->with('success', 'You have been logged out successfully.');
    }
}