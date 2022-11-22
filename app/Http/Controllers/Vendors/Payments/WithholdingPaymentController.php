<?php

namespace App\Http\Controllers\Vendors\Payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actions\Vendors\Payments\GetAllWithholdingPeriods;

class WithholdingPaymentController extends Controller
{
    public function ajaxGetAll()
    {



        $withholding_periods = GetAllWithholdingPeriods::run();

        return response()->json($withholding_periods);
    }
}
