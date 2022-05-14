<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReferralsController extends Controller
{
    public function index()
    {
        return view('referrals.index');
    }
}
