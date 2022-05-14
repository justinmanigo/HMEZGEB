<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
        // Retrieves the accounting systems' the authenticated user belongs.
        $user = User::find(Auth::id());
        $user->accountingSystemUsers;

        // If the number of accounting systems' is only one, skip ahead to dashboard.
        if(count($user->accountingSystemUsers)) {
            $this->request->session()->put('accounting_system_id', $user->accountingSystemUsers[0]->accounting_system_id);
            return redirect('/');
        }
        
        // Otherwise, let the authenticated user select which accounting system to manage.
        return view('view-accounting-systems');
    }

    public function switchAccountingSystem()
    {
        $this->request->session()->put('accounting_system_id', $this->request->accounting_system_id);
        return redirect('/');
    }


   

}
