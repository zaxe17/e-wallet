<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8',
            'confirm_password' => 'required|same:new_password',
        ]);

        $userId = Session::get('user_id');

        try {
            // Get current password from database
            $user = DB::selectOne("
                SELECT password FROM user WHERE userid = ?
            ", [$userId]);

            // Verify current password
            if (!password_verify($request->current_password, $user->password)) {
                return back()->with('error', 'Current password is incorrect.');
            }

            // Update with new password
            DB::update("
                UPDATE user 
                SET password = ? 
                WHERE userid = ?
            ", [
                password_hash($request->new_password, PASSWORD_DEFAULT),
                $userId
            ]);

            return redirect()->route('settings.index')
                ->with('success', 'Password changed successfully!');
        } catch (\Throwable $e) {
            Log::error('Change password error: ' . $e->getMessage());
            return back()->with('error', 'Failed to change password.');
        }
    }

    public function changePasskey(Request $request)
    {
        $request->validate([
            'current_pin' => 'required|digits:4',
            'new_pin' => 'required|digits:4',
            'confirm_pin' => 'required|digits:4|same:new_pin',
        ]);

        $userId = Session::get('user_id');

        try {
            // Get current passkey from database
            $user = DB::selectOne("
                SELECT passkey FROM user WHERE userid = ?
            ", [$userId]);

            // Verify current passkey (only if it exists)
            if ($user->passkey !== null && $user->passkey !== $request->current_pin) {
                return back()->with('error', 'Current PIN is incorrect.');
            }

            // Update with new passkey
            DB::update("
                UPDATE user 
                SET passkey = ? 
                WHERE userid = ?
            ", [
                $request->new_pin,
                $userId
            ]);

            return redirect()->route('settings.index')
                ->with('success', 'Savings PIN changed successfully!');
        } catch (\Throwable $e) {
            Log::error('Change passkey error: ' . $e->getMessage());
            return back()->with('error', 'Failed to change PIN.');
        }
    }
}