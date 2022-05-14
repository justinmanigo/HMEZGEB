<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function viewAccountingSystems()
    {
        return view('view-accounting-systems');
    }

    public function switchAccountingSystem()
    {
        // TODO: Check if accounting system exists
        $this->request->session()->put('accounting_system_id', $this->request->accounting_system_id);
        return redirect('/');
    }


   

}
