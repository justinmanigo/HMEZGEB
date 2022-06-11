<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DefaultsController extends Controller
{
    // TODO: Index
    public function index()
    {
        return view('settings.defaults.index');
    }

    public function updateReceipts(Request $request)
    {
        //
    }

    public function updateAdvanceReceipts(Request $request)
    {
        //
    }

    public function updateCreditReceipts(Request $request)
    {
        //
    }

    public function updateBills(Request $request)
    {
        //
    }

    public function updatePayments(Request $request)
    {
        //
    }
}
