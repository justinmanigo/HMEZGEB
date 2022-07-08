<?php

namespace App\Http\Controllers\Subscription;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManageSubscriptionUsersController extends Controller
{
    public function index()
    {
        return view('subscription.users.index');
    }
}
