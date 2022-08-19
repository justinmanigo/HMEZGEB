<?php

namespace App\Http\Controllers\Banking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BankReconciliationController extends Controller
{
    public function index()
    {
        return view('banking.reconciliation.index', [
        ]);
    }
}
