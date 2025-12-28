<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PasskeyController extends Controller
{
    public function validatePasskey(Request $request)
    {
        // Validate passkey
        $request->validate([
            'passkey' => 'required|digits:4'
        ]);

        $enteredPasskey = $request->input('passkey');
        $userId = Session::get('user_id');

        $passkeyCheckSql = "SELECT passkey FROM savings WHERE userid = ? ORDER BY date_of_save DESC LIMIT 1";
        $result = DB::select($passkeyCheckSql, [$userId]);

        if (empty($result) || $result[0]->passkey !== $enteredPasskey) {
            return response()->json(['success' => false]);
        }

        return response()->json(['success' => true]);
    }
}
