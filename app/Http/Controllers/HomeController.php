<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        
        return view('home');
    }

    public function vendor()
    {
        return view('vendor');
    }

    public function bill()
    {
        return view('bill');
    }
    public function individualVendor()
    {
        return view('individualVendor');
    }
    public function individualBill()
    {
        return view('individualBill');
    }

}
