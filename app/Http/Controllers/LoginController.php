<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function index()
    {
        return view('pages.login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email_username' => 'required|string',
            'password' => 'required|string',
        ]);

        try {
            $sql = "
                SELECT * FROM user 
                WHERE email_address = ? OR username = ?
                LIMIT 1
            ";

            $users = DB::select($sql, [
                $request->email_username,
                $request->email_username
            ]);

            if (!empty($users)) {
                $user = $users[0];

                if (Hash::check($request->password, $user->password)) {
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

    public function destroy()
    {
        Session::flush();
        return redirect()->route('loginForm')
            ->with('success', 'You have been logged out successfully.');
    }
}