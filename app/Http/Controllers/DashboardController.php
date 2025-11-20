<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        $navtitle = 'Dashboard';
        return view('pages.dashboard', compact('navtitle'));
    }
}
