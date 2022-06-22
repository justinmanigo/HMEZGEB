<?php

namespace App\Http\Controllers;

use App\Models\Register;
use App\Models\Referral;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function findReferralCode(Request $request)
    {
        Log::info($request);
        
        $referral = Referral::where('code', $request->referralCode)->firstOrFail();

        $this->request->session()->put('referralCode',$request->referralCode);
        Log::info($this->request->session()->get('referralCode'));

        return 'sod';
    }
   
    public function createAccount(Request $request)
    {
         
        Log::info($request);
        $this->request->session()->put('registerEmail',$request->registerEmail);
        //     //1.Find email address
        //     //2.If email exist return to verify password and compare password and ask if to merged account
        //     //2.1.If merged, redirect to create new another company info and redirect to dashboard
        //     //2.2.Else redirect back to input email address
        //     //3.Else if not exist input newly created password and redirect to input user details
        // }
        if($this->request->session()->get('referralCode')){
            $user = User::where('email',$request->registerEmail)->first();
            Log::info($user);
            if($user){
                Log::info("sod");
                return redirect()->route('register.verifyPasswordView');  
            }else{
                Log::info("wa sod");
               
                return redirect()->route('register.createPasswordView'); 
            }
        }else{
            abort(500);
        }
    }

    public function createPassword(Request $request)
    {
        Log::info($request);
        // $this->validate($request, [
        //     'createpassword' => 'required|confirmed|min:6',
        //     'repeatPassword' => 'required',
        // ]);

        $this->request->session()->put('createpassword',$request->createpassword);
        Log::info( $this->request->session()->get('createpassword'));
        return redirect()->route('register.createUser');  
    }

    public function verifyPassword(Request $request)
    {
        Log::info($request);

        Log::warning($this->request->session()->get('registerEmail'));
        $existpassword = User::where('email',$this->request->session()->get('registerEmail'))->first();
        Log::info($existpassword);
            if (Hash::check($request->existpassword, $existpassword->password)) {
                Log::info("sod");
                return redirect()->route('register.createCompanyInfoView');  
            }else{
                Log::info("wa sod");
                return redirect()->back()->with('error','Incorrect password please try again!');
            }
    }


    public function createAccountView()
    {
        if($this->request->session()->get('referralCode')){
            return view('register.create-account');
        }else{
            abort(404);
        }
    }

    

    public function createPasswordView()
    {
       
        return view('register.create-password');
    }

    public function createUserView()
    {
        
        // if(session()->has('email')){
        //     //1.store new user and redirect to create new company info and redirect to dashboard

        // }

        return view('register.create-user');
       
    }

    public function verifyPasswordView()
    {
        return view('register.verify-password');
    }

    public function createCompanyInfoView()
    {
        return view('register.create-company-info');
    }

   



























  /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Register  $register
     * @return \Illuminate\Http\Response
     */
    public function show(Register $register)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Register  $register
     * @return \Illuminate\Http\Response
     */
    public function edit(Register $register)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Register  $register
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Register $register)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Register  $register
     * @return \Illuminate\Http\Response
     */
    public function destroy(Register $register)
    {
        //
    }
}
