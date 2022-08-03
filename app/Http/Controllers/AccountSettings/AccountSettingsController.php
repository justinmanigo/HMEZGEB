<?php

namespace App\Http\Controllers\AccountSettings;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\AccountSettings\UpdateUsernameRequest;
use App\Http\Requests\AccountSettings\UpdateEmailRequest;
use App\Http\Requests\AccountSettings\UpdatePasswordRequest;
use App\Models\User;

class AccountSettingsController extends Controller
{
    /**
     * Your Account Page
     */
    public function index()
    {
        return view('account_settings.index');
    }

    /**
     * Confirms and Enables 2FA to currently authenticated user.
     */
    public function confirm2FA(Request $request)
    {
        $confirmed = $request->user()->confirmTwoFactorAuth($request->code);

        if (!$confirmed) {
            return back()->withErrors('Invalid Two Factor Authentication code');
        }

        return back();
    }

    /**
     * Displays recovery codes of currently authenticated user.
     */
    public function showRecoveryCodes()
    {
        foreach(Auth::user()->recoveryCodes() as $code)
            echo $code . '<br>';
    }

    /**
     * Updating Info from Account Settings
     */

    public function updateUsername(UpdateUsernameRequest $request)
    {
        $validated = $request->validated();

        return User::find(Auth::user()->id)->update([
            'username' => $validated['username'],
        ]);
    }

    public function updateEmail(UpdateEmailRequest $request)
    {
        $validated = $request->validated();

        return User::find(Auth::user()->id)->update([
            'email' => $validated['email'],
        ]);
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $validated = $request->validated();

        return User::find(Auth::user()->id)->update([
            'password' => Hash::make($validated['new_password']),
            'password_updated_at' => now(),
            'must_update_password' => false,
        ]);
    }
}