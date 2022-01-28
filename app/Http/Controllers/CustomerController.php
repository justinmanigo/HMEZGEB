<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Show the receipts page of customers menu.
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function receipt()
    {
        return view('customers.receipt');
    }

    /**
     * Show the customers page of customers menu.
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function customer()
    {
        return view('customers.customer');
    }

    /**
     * Shows the deposit page of customers menu.
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function deposit()
    {
        return view('customers.deposit');
    }
}
