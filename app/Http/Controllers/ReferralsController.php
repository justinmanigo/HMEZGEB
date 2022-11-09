<?php

namespace App\Http\Controllers;

use App\Actions\CreateReferral;
use App\Http\Requests\StoreReferralRequest;
use App\Http\Requests\StoreAdvancedReferralRequest;
use App\Http\Requests\Referral\GenerateReferralsRequest;
use App\Mail\Referral\InviteUser;
use App\Models\Referral;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ReferralsController extends Controller
{
    public function index()
    {
        $referrals = Referral::select(
                'referrals.id as id',
                'referrals.code as code',
                'referrals.type as type',
                'referrals.name as referred_owner', // use only in case code is never used.
                DB::raw('CONCAT(users.firstName, " ", users.lastName) as subscription_owner'),
                DB::raw('IFNULL(subscriptions.status, "unused") as status'),
                'referrals.email as email',
                'referrals.created_at',
                'referrals.updated_at',
            )
            ->leftJoin('subscriptions', 'subscriptions.referral_id', '=', 'referrals.id')
            ->leftJoin('users', 'users.id', '=', 'subscriptions.user_id')
            ->where('referrals.user_id', Auth::id())
            ->get();

        return view('referrals.index', [
            'referrals' => $referrals,
        ]);
    }

    public function show(Referral $referral)
    {
        // Check if Referral's User ID == Authenticated User ID
        if($referral->user_id != Auth::id()) {
            abort(404);
        }

        $referral->subscription;
        if($referral->subscription) $referral->subscription->user;

        return view('referrals.show', [
            'referral' => $referral,
        ]);
    }

    public function storeNormalReferral(StoreReferralRequest $request)
    {
        $validated = $request->validated();

        $referral = CreateReferral::run($validated, 'normal');

        Mail::to($referral->email)->queue(new InviteUser(auth()->user(), $referral->code));

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

        Mail::to($referral->email)->queue(new InviteUser(auth()->user(), $referral->code));

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

    /**
     * Removes the code from the database as the code is no longer valid.
     */
    public function rejectInvitation($encrypted)
    {
        $key = config('app.key');

        $encrypted = str_replace(['-', '_', ''], ['+', '/', '='], $encrypted);

        $method = 'AES-256-CBC';
        $iv = substr(hash('sha256', $key), 0, 16);
        $code = openssl_decrypt($encrypted, $method, $key, 0, $iv);

        $referral = Referral::where('code', $code)->first();

        if($referral) {
            $referral->delete();
            return view('referrals.reject');
        } else {
            abort(404);
        }
    }
}
