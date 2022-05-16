<?php

namespace App\Http\Controllers;

use App\Actions\CreateReferral;
use App\Http\Requests\StoreReferralRequest;
use App\Models\Referral;
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

        CreateReferral::run($validated);

        return redirect('/referrals')->with('success', 'Successfully created a referral.');
    }
}
