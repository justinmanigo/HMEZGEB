<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OvertimeController extends Controller
{
    /**
     * Show the overtime page of human resource menu.
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('hr.overtime.index');
    }
}
