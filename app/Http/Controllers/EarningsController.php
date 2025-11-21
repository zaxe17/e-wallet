<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EarningsController extends Controller
{
    public function index() {
        $navtitle = 'Earnings';
        return view('pages.earnings', compact('navtitle'));
    }
}
