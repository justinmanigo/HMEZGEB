<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdditionController extends Controller
{
    /**
     * Show the additions page of human resource menu.
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('hr.addition.index');
    }
}
