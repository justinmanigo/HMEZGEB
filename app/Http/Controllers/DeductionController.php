<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeductionController extends Controller
{
    /**
     * Show the deductions page of human resource menu.
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('hr.deduction.index');
    }
}
