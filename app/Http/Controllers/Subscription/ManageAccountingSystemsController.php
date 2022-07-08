<?php

namespace App\Http\Controllers\Subscription;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManageAccountingSystemsController extends Controller
{
    public function index()
    {
        return view('subscription.accounting_system.index');
    }
}
