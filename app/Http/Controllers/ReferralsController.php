<?php

namespace App\Http\Controllers;

use App\Actions\CreateReferral;
use App\Http\Requests\StoreReferralRequest;
use App\Http\Requests\StoreAdvancedReferralRequest;
use App\Http\Requests\Referral\GenerateReferralsRequest;
use App\Models\Referral;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;

class ReferralsController extends Controller
{
    public function index()
    {
        $referrals = Referral::where('user_id', Auth::id())->get();

        return view('referrals.index', [
            'referrals' => $referrals,
        ]);
    }

    public function storeNormalReferral(StoreReferralRequest $request)
    {
        $validated = $request->validated();

        CreateReferral::run($validated, 'normal');

        return 'Successfully created a referral.';
    }

    public function storeAdvancedReferral(StoreAdvancedReferralRequest $request)
    {
        $validated = $request->validated();

        $referral = CreateReferral::run($validated, 'advanced');

        Subscription::create([
            'referral_id' => $referral->id,
            'account_type' => $validated['account_type'],
            'account_limit' => $validated['account_type'] == 'admin' 
                || $validated['account_type'] == 'super admin'
                    ? $validated['number_of_accounts'] 
                    : 1,
        ]);

        return 'Successfuly created an advanced referral.';
    }

    public function generateReferrals(GenerateReferralsRequest $request)
    {
        $validated = $request->validated();

        for($i = 0; $i < $validated['number_of_codes']; $i++) 
        {
            $referral = Referral::create([
                'user_id' => Auth::id(),
                'type' => $validated['referral_type'],
                'trial_duration' => $validated['referral_type'] == 'normal' 
                    ? 1 
                    : $validated['trial_duration'],
                'trial_duration_type' => $validated['referral_type'] == 'normal' 
                    ? 'week' 
                    : $validated['trial_duration_type'],
            ]);

            if($validated['referral_type'] == 'advanced') {
                Subscription::create([
                    'referral_id' => $referral->id,
                    'account_type' => $validated['account_type'],
                    'account_limit' => $validated['account_type'] == 'admin' 
                        || $validated['account_type'] == 'super admin'
                            ? $validated['number_of_accounts'] 
                            : 1,
                ]);
            }
        }

        return true;
    }
}
