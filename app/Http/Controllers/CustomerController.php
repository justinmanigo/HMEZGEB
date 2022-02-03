<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Show the customers page of customers menu.
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('customer.index');
    }

}
