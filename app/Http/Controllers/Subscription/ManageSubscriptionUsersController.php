<?php

namespace App\Http\Controllers\Subscription;

use App\Http\Controllers\Controller;
use App\Http\Requests\Subscription\AddExistingUserRequest;
use App\Models\AccountingSystemUser;
use App\Models\Subscription;
use App\Models\SubscriptionUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Kaiopiola\Keygen\Key;

class ManageSubscriptionUsersController extends Controller
{
    public function index()
    {
        // Get subscription
        $user = User::find(auth()->id());
        $user->subscriptions;
        for($i = 0; $i < count($user->subscriptions); $i++) {
            $user->subscriptions[$i]->subscriptionUsers;
            for($j = 0; $j < count($user->subscriptions[$i]->subscriptionUsers); $j++) {
                $user->subscriptions[$i]->subscriptionUsers[$j]->user;
            }
        }
        // return $user;

        return view('subscription.users.index', [
            'user' => $user,
        ]);
    }

    public function ajaxGetUser(User $user)
    {
        return $user;
    }

    public function ajaxSearchUser($query)
    {
        return User::where(function ($q) use ($query) {
            $q->where('firstName', 'LIKE', '%' . $query . '%')
                ->orWhere('lastName', 'LIKE', '%' . $query . '%')
                ->orWhere('email', 'LIKE', '%' . $query . '%');
        })
        ->select(
            'id as value',
            DB::raw('CONCAT(firstName, " ", lastName) AS name'),
            'email',   
        )
        ->get();
    }

    public function ajaxAddNewUser(Request $request)
    {
        $exampleKey = new Key;
        $exampleKey->setPattern("XXXXXXXX");
        $username = strtolower((string)$exampleKey->generate());
        $password = strtolower((string)$exampleKey->generate());

        $user = User::create([
            'firstName' => $request->first_name,
            'lastName' => $request->last_name,
            'email' => $request->email,
            'username' => $username,
            'password' => bcrypt($password),
        ]);

        $subscription_user = SubscriptionUser::create([
            'subscription_id' => $request->subscription_id,
            'user_id' => $user->id,
            'role' => $request->role,
        ]);

        return response()->json([
            'success' => true,
            'subscription_id' => $request->subscription_id,
            'subscription_user' => $subscription_user,
            'user' => $user,
            // 'password' => $password, // TODO: send email with password when invited
        ]);
    }

    public function ajaxAddExistingUser(AddExistingUserRequest $request)
    {
        $subscription_user = SubscriptionUser::create([
            'subscription_id' => $request->subscription_id,
            'user_id' => $request->user->value,
            'role' => $request->role,
        ]);

        return response()->json([
            'success' => true,
            'subscription_id' => $request->subscription_id,
            'subscription_user' => $subscription_user,
            'user' => $request->user,
        ]);
    }

    public function ajaxGetAccountingSystems(Subscription $subscription)
    {
        return $subscription->accountingSystems;
    }

    public function ajaxAddAccess(SubscriptionUser $subscriptionUser, Request $request)
    { 
        for($i = 0; $i < count($request->accounting_systems); $i++) {
            $as[] = AccountingSystemUser::create([
                'accounting_system_id' => $request->accounting_systems[$i],
                'subscription_user_id' => $subscriptionUser->id,
            ]);

            // Add all permissions
            for($j = 1; $j <= 24; $j++)
            {
                $permissions[] = [
                    'accounting_system_user_id' => $as[$i]->id,
                    'access_level' => 'rw',
                    'sub_module_id' => $j,
                ];
            }

            DB::table('permissions')->insert($permissions);
        }

        return response()->json([
            'success' => true,
            'subscription_user' => $subscriptionUser,
            'accounting_systems' => $as,
        ]);
    }
}
