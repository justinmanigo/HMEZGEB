<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DepositController extends Controller
{
    /**
     * Shows the deposit page of customers / banking menu.
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('deposit.index');
    }

    /**
     * Shows the new deposit page of customers / banking menu.
     */
    public function new()
    {
        return view('deposit.new');
    }
}
