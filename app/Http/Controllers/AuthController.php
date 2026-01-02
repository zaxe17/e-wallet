<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function logout(Request $request)
    {
        Session::forget('user_id');

        Session::flush();

        $request->session()->regenerate();

        return redirect('/login')->with('success', 'Logged out successfully');
    }
}
