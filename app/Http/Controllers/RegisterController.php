<?php

namespace App\Http\Controllers;

use App\Actions\CreateAccountingSystem;
use App\Http\Requests\CreateAccountingSystemRequest;
use App\Http\Requests\CreateAccountRequest;
use App\Http\Requests\ValidateExistingAccountRequest;
use App\Models\AccountingSystem;
use App\Models\Register;
use App\Models\Referral;
use App\Models\Subscription;
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

        // Check if the referral code is already used or not.
        $subscription = Subscription::where('referral_id', $referral->id)->first();

        if((isset($subscription) && $referral->type == 'normal') ||
            (isset($subscription) && $subscription->date_from != null && $referral->type == 'advanced')){
            return response()->json(['error' => 'Referral code is already used by someone else.'], 422);
        }

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
        // if(!$user) return response()->json(['error' => 'Email does not exist.'], 422);

        // if(!Hash::check($request->password, $user->password)) return response()->json(['error' => 'Invalid password.'], 422);

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
        $user->password = Hash::make($request->new_password);
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
     */
    public function createAccountingSystem(CreateAccountingSystemRequest $request)
    {
        // return $request;

        if(session('referralCode')){
            try {
                $referral = Referral::where('code', $request->referral_code)->firstOrFail();
            } catch (\Exception $e) {
                return response()->json(['error' => 'Error processing request.'], 422);
            }
    
            $subscription = Subscription::where('referral_id', $referral->id)->first();
    
            if((isset($subscription) && $referral->type == 'normal') ||
                (isset($subscription) && $subscription->date_from != null && $referral->type == 'advanced')){
                return response()->json(['error' => 'Can\'t create accounting system. Referral code is already used by someone else.'], 422);
            }

            // Determine Date To
            $dateTo = \Carbon\Carbon::now();
            switch($referral->trial_duration_type)
            {
                case 'day':
                    $dateTo = $dateTo->addDays($referral->trial_duration);
                    break;
                case 'week':
                    $dateTo = $dateTo->addWeeks($referral->trial_duration);
                    break;
                case 'month':
                    $dateTo = $dateTo->addMonths($referral->trial_duration);
                    break;
            }

            if(!$subscription)
            {
                // Create Subscription
                $subscription = Subscription::create([
                    'referral_id' => $referral->id,
                    'user_id' => Auth::user()->id,
                    'account_limit' => 3,
                    'account_type' => 'admin',
                    'date_from' => now()->format('Y-m-d'),
                    'date_to' => $dateTo->format('Y-m-d'),
                    'status' => 'trial', // TODO: Update this one when support for `paid` is added.
                ]);
            }
            else {
                // Update subscription
                $subscription->user_id = Auth::user()->id;
                $subscription->date_from = now()->format('Y-m-d');
                $subscription->date_to = $dateTo->format('Y-m-d');
                $subscription->status = 'trial'; // TODO: Update this one when support for `paid` is added.
                $subscription->save();
            }
        }
        else {
            $user = User::find(auth()->id());
            $user->subscriptions;
            $idx = -1;
            for($i = 0; $i < count($user->subscriptions); $i++) {
                $user->subscriptions[$i]->accountingSystems;
                $num_accts[] = $user->subscriptions[$i]->accountingSystems->count();
                $acct_limit[] = $user->subscriptions[$i]->account_limit;
                if($acct_limit = $num_accts > 0) {
                    $idx = $i;
                    break;
                }
            }

            if($idx == -1)
            {
                return response()->json(['error' => 'You no longer have available accounting system slots to process this request. Please upgrade your subscription first.'], 422);
            }
        }

        // Create the accounting system
        $as = CreateAccountingSystem::run($request, isset($subscription) ? $subscription : $user->subscriptions[$idx]);

        // Add accounting system to session
        $this->request->session()->put('accounting_system_id', $as['accounting_system']->id);
        $this->request->session()->put('accounting_system_user_id', $as['accounting_system_user']->id);

        // Remove referral code to session
        $this->request->session()->forget('referralCode');

        return response()->json(['success' => true], 200);
    }

    public function cancelOnboarding()
    {
        // Remove referral code to session
        $this->request->session()->forget('referralCode');

        return redirect('/switch');
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
        if(!session('referralCode')){
            $user = User::find(auth()->id());
            $user->subscriptions;
            $idx = -1;
            for($i = 0; $i < count($user->subscriptions); $i++) {
                $user->subscriptions[$i]->accountingSystems;
                $num_accts[] = $user->subscriptions[$i]->accountingSystems->count();
                $acct_limit[] = $user->subscriptions[$i]->account_limit;
                if($acct_limit = $num_accts > 0) {
                    $idx = $i;
                    break;
                }
            }

            if($idx == -1)
                abort(404);
        }
        // return [
        //     Auth::user(),
        //     session('referralCode')
        // ];
        return view('register.create-company-info');
    }

}
