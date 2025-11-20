<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserPageController extends Controller
{
    public function dashboard() {
        return view('pages.dashboard');
    }
    
    public function earnings() {
        return view('pages.earnings');
    }
    
    public function expenses() {
        return view('pages.expenses');
    }
    
    public function savings() {
        return view('pages.savings');
    }
}
