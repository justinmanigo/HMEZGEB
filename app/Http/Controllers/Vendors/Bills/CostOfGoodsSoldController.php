<?php

namespace App\Http\Controllers\Vendors\Bills;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Vendors\Bills\StoreCostOfGoodsSoldRequest;

class CostOfGoodsSoldController extends Controller
{
    public function store(StoreCostOfGoodsSoldRequest $request)
    {
        return $request;
    }
}
