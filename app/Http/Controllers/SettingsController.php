<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SettingsController extends Controller
{
    public function index()
    {
        $navtitle = 'Settings';
        $userId = Session::get('user_id');

        $user = DB::selectOne("
            SELECT full_name, username, email_address, phone_number
            FROM user
            WHERE userid = ?
        ", [$userId]);

        $nameParts = explode(' ', trim($user->full_name));
        $count = count($nameParts);

        $lastName = $count >= 1 ? $nameParts[$count - 1] : '';
        $middleName = $count >= 2 ? $nameParts[$count - 2] : '';
        $firstName = $count > 2
            ? implode(' ', array_slice($nameParts, 0, $count - 2))
            : ($nameParts[0] ?? '');

        return view('pages.settings', compact(
            'navtitle',
            'firstName',
            'middleName',
            'lastName',
            'user'
        ));
    }

    public function save(Request $request)
    {
        $userId = Session::get('user_id');

        $request->validate([
            'first_name' => 'required|string',
            'middle_name' => 'nullable|string',
            'last_name' => 'required|string',
            'username' => 'required|string|unique:user,username,' . $userId . ',userid',
            'email_address' => 'required|email',
            'phone_number' => 'required|digits:11',
        ]);

        $fullName = trim(
            $request->first_name . ' ' .
                ($request->middle_name ? $request->middle_name . ' ' : '') .
                $request->last_name
        );

        DB::update("
            UPDATE user
            SET
                full_name = ?,
                username = ?,
                email_address = ?,
                phone_number = ?
            WHERE userid = ?
        ", [
            $fullName,
            $request->username,
            $request->email_address,
            $request->phone_number,
            $userId
        ]);

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
}
