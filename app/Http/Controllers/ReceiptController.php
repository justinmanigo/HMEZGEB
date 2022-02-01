<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    /**
     * Show the receipts page of customers menu.
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('receipt.index');
    }

    /**
     * Show the new receipt form of customers menu.
     */
    public function new_receipt()
    {
        return view('receipt.new_receipt');
    }

    /**
     * Show the new advance revenue form of customers menu.
     */
    public function new_advance_revenue()
    {
        return view('receipt.new_advance_revenue');
    }

    /**
     * Show the new proforma form of customers menu.
     */
    public function new_proforma()
    {
        return view('receipt.new_proforma');
    }
}
