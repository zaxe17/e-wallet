<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SavingsController extends Controller
{
    public function index() {
        $navtitle = 'Savings';
        return view('pages.savings', compact('navtitle'));
    }
}
