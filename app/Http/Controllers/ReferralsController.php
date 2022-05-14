<?php

namespace App\Http\Controllers;

use App\Models\Referral;
use App\Http\Requests\StoreReferralRequest;
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

        Referral::create([
            'user_id' => Auth::user()->id,
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        return redirect('/referrals')->with('success', 'Successfully created a referral.');
    }
}
