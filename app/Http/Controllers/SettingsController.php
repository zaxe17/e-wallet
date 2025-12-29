<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SettingsController extends Controller
{
    public function index()
    {
        $navtitle = 'Settings';
        $userId = Session::get('user_id');

        return view('pages.settings', compact('navtitle'));
    }
}
