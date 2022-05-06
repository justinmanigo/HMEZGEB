<?php

namespace App\Http\Controllers\AccountSettings;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUsernameRequest;
use App\Http\Requests\UpdateEmailRequest;
use App\Http\Requests\UpdatePasswordRequest;
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
        ]);
    }
}