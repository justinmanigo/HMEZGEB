<?php

namespace App\Http\Controllers\Control;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\SubscriptionUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Kaiopiola\Keygen\Key;

class SuperAdminController extends Controller
{
    public function index()
    {
        // Query Super Admins
        $super_admins = User::where('control_panel_role', '!=', NULL)
            ->where('id', '!=', Auth::user()->id)
            ->where('id', '!=', 1)
            ->get();

        return view('control_panel.super_admins.index', [
            'super_admins' => $super_admins
        ]);
    }

    /**
     * AJAX endpoint to invite a new super admin user account.
     */
    public function ajaxInviteUser(Request $request)
    {
        $exampleKey = new Key();
        $exampleKey->setPattern('XXXXXXXX');
        $username = strtolower((string)$exampleKey->generate());
        $password = strtolower((string)$exampleKey->generate());

        $user = User::firstOrCreate([
            'email' => $request->email,
        ], [
            'username' => $username,
            'password' => Hash::make($password),
        ]);

        if($user->is_control_panel_access_accepted)
        {
            return response()->json([
                'success' => false,
                'message' => 'User already has access to the control panel.'
            ]);
        }

        $subscription = Subscription::updateOrCreate([
            'user_id' => $user->id,
            'account_type' => 'super admin',
        ], [
            'account_limit' => 10,
            'date_from' => now(),
            'date_to' => null,
            'status' => 'active',
        ]);

        $subscription_user = SubscriptionUser::firstOrCreate([
            'subscription_id' => $subscription->id,
            'user_id' => $user->id,
            'role' => 'super admin',
        ], [
            'is_accepted' => false,
        ]);

        $user->control_panel_role = $request->control_panel_role;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'User has been invited to the control panel.',
            'user' => $user
        ]);
    }

    public function acceptInvitation(Request $request)
    {
        $user = User::find(Auth::user()->id);
        // check password
        if(!Hash::check($request->password, $user->password))
        {
            return redirect()->route('control.index')
                ->with('error', 'Password is incorrect.');
        }

        $user->is_control_panel_access_accepted = true;
        $user->save();

        $subscription = Subscription::where('user_id', $user->id)
            ->where('account_type', 'super admin')
            ->first();

        $subscription_user = SubscriptionUser::where('subscription_id', $subscription->id)
            ->where('user_id', $user->id)
            ->where('role', 'super admin')
            ->first();

        $subscription_user->is_accepted = true;
        $subscription_user->save();

        return redirect()->route('control.index')
            ->with('success', 'You have accepted the invitation to the control panel.');
    }

    public function rejectInvitation()
    {
        $user = User::find(Auth::user()->id);
        $user->is_control_panel_access_accepted = false;
        $user->control_panel_role = null;
        $user->save();

        return redirect('/switch')
            ->with('success', 'You have rejected the invitation to the control panel.');
    }

    /**
     * 
     */
    public function editSuperAdmin(User $user, Request $request)
    {
        $user->control_panel_role = $request->control_panel_role;
        $user->save();

        return response()->json([
            'success' => true,
            'user' => $user
        ]);
    }

    /**
     * 
     */
    public function removeSuperAdmin(User $user)
    {
        $user->control_panel_role = NULL;
        $user->save();

        // Expire subscription in 7 days
        $subscription = Subscription::where('user_id', $user->id)
            ->where('account_type', 'super admin')
            ->first();

        $subscription->date_to = now()->addDays(7);
        $subscription->save();

        return response()->json([
            'success' => true,
            'user' => $user
        ]);
    }

    /**
     * AJAX endpoint to search for users that aren't super admins.
     */
    public function ajaxSearchUser($query = null)
    {
        return User::where(function ($q) use ($query) {
            $q->where('firstName', 'LIKE', '%' . $query . '%')
                ->orWhere('lastName', 'LIKE', '%' . $query . '%')
                ->orWhere('email', 'LIKE', '%' . $query . '%');
        })
        ->where('control_panel_role', NULL)
        ->select(
            'id as value',
            DB::raw('CONCAT(firstName, " ", lastName) AS name'),
            'email',   
        )
        ->get();
    }

    /**
     * AJAX endpoint to get user details.
     */
    public function ajaxGetUser(User $user)
    {
        return $user;
    }
}
