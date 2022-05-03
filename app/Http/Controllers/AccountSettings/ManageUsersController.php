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

class ManageUsersController extends Controller
{
    /**
     * Manage Users Page
     */
    public function index()
    {
        return view('account.manageUsers.index');
    }
}