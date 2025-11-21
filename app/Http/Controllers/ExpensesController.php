<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExpensesController extends Controller
{
    
    public function index() {
        $navtitle = 'Expenses';
        return view('pages.expenses', compact('navtitle'));
    }
}
