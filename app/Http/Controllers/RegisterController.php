<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAccountingSystemRequest;
use App\Http\Requests\CreateAccountRequest;
use App\Http\Requests\ValidateExistingAccountRequest;
use App\Models\Register;
use App\Models\Referral;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Kaiopiola\Keygen\Key;

class RegisterController extends Controller
{
    /**
     * Step 0
     * This function checks whether the referral code exists or not.
     * If the referral code exists, it will return 'sod', thus the frontend will
     * redirect to the create account view.
     */
    public function findReferralCode(Request $request)
    {
        Log::info($request);
        
        $referral = Referral::where('code', $request->referralCode)->firstOrFail();

        $this->request->session()->put('referralCode',$request->referralCode);
        Log::info($this->request->session()->get('referralCode'));

        return 'sod';
    }

    /**
     * Step 1
     * This functions checks whether the email exists.
     * 
     * If the email exists, in the front end, it will proceed to step 2A where the user
     * will confirm his/her identity and merge accounts.
     * Otherwise, it will proceed to Step 2B where the user will create a new account.
     */
    public function checkIfEmailExists(Request $request)
    {
        Log::info($request);

        if(!session('referralCode')){
            return response()->json(['error' => 'Error processing request.'], 422);
        }

        // Check whether the email is registered or not.
        $user = User::where('email', $request->email)->first();

        if($user)   return response()->json(['email_exists' => true], 200);
        else        return response()->json(['email_exists' => false], 200);
    }

    /**
     * Step 2a
     * This function validates the existing account credentials. Then logs the user in and proceeds
     * to the referral code onboarding.
     * 
     * TODO: Create a middleware that checks if a referral code exists in the session, 
     * thus will redirect to the accounting system onboarding process.
     * If the user wishes to cancel, then the referral code will not be consumed and the session
     * key will be removed. Then redirects to the switch account view.
     */
    public function validateExistingAccount(ValidateExistingAccountRequest $request)
    {
        // return $request;

        // Validates the account then logs the user in
        $user = User::where('email', $request->email)->first();
        if(!$user) return response()->json(['error' => 'Error processing request.'], 422);

        if(!Hash::check($request->password, $user->password)) return response()->json(['error' => 'Error processing request.'], 422);

        // Logs the user in
        Auth::login($user);

        // Returns true that signals that the user is logged in.
        return response()->json(['success' => true], 200);
    }

    /**
     * Step 2b
     * This function validates the new account credentials, then creates a new account.
     * 
     * TODO: Create a middleware that checks if a referral code exists in the session, 
     * thus will redirect to the accounting system onboarding process.
     * If the user wishes to cancel, then the referral code will not be consumed and the session
     * key will be removed. Then redirects to the switch account view.
     */
    public function createAccount(CreateAccountRequest $request)
    {
        // return $request;

        // Validates the account then creates the account
        $user = new User;
        $user->email = $request->email;
        // generate random username
        $exampleKey = new Key;
        $exampleKey->setPattern("XXXXXXXX");
        $user->username = (string)$exampleKey->generate();
        $user->code = (string)$exampleKey->generate();
        $user->password = Hash::make($request->password);
        $user->save();

        // Logs the user in
        Auth::login($user);

        // Returns true that signals that the user is logged in.
        return response()->json(['success' => true], 200);
    }

    /**
     * Step 3
     * This function creates the accounting system of the user. The same function also links
     * the stored referral code to the user, disallowing reuse for other users.
     * 
     * TODO: Create Accounting System for the User
     */
    public function createAccountingSystem(CreateAccountingSystemRequest $request)
    {
        return $request;
    }
   
    // public function createAccount(Request $request)
    // {
        

         
        // Log::info($request);
        // $this->request->session()->put('registerEmail',$request->registerEmail);
        // //     //1.Find email address
        // //     //2.If email exist return to verify password and compare password and ask if to merged account
        // //     //2.1.If merged, redirect to create new another company info and redirect to dashboard
        // //     //2.2.Else redirect back to input email address
        // //     //3.Else if not exist input newly created password and redirect to input user details
        // // }
        // if($this->request->session()->get('referralCode')){
        //     $user = User::where('email',$request->registerEmail)->first();
        //     Log::info($user);
        //     if($user){
        //         Log::info("sod");
        //         return redirect()->route('register.verifyPasswordView');  
        //     }else{
        //         Log::info("wa sod");
               
        //         return redirect()->route('register.createPasswordView'); 
        //     }
        // }else{
        //     abort(500);
        // }
    // }

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
        // return [
        //     Auth::user(),
        //     session('referralCode')
        // ];
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
