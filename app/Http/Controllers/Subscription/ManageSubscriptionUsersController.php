<?php

namespace App\Http\Controllers\Subscription;

use App\Http\Controllers\Controller;
use App\Http\Requests\Subscription\AddAccountingSystemAccessRequest;
use App\Http\Requests\Subscription\AddExistingUserRequest;
use App\Models\AccountingSystem;
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
        $subscription_access = SubscriptionUser::where('user_id', auth()->id())->get();

        $result = [];

        for($i = 0; $i < count($subscription_access); $i++)
        {
            $result[$i]['subscription'] = Subscription::find($subscription_access[$i]->subscription_id);

            $result[$i]['users'] = SubscriptionUser::where('subscription_id', $subscription_access[$i]->subscription_id)
                ->leftJoin('users', 'users.id', '=', 'subscription_users.user_id')
                ->select('users.firstName', 'users.lastName', 'users.email', 'users.id as user_id', 'subscription_users.id as id', 'subscription_users.role')
                ->get();
        }
        return view('subscription.users.index', [
            'result' => $result,
        ]);
    }

    public function ajaxGetUser(User $user)
    {
        return $user;
    }

    public function ajaxGetSubscriptionUser(SubscriptionUser $subscriptionUser)
    {
        $subscriptionUser->user;

        return $subscriptionUser;
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
        $subscription_access = SubscriptionUser::where('user_id', auth()->id())
            ->where('subscription_id', $subscription->id)
            ->firstOrFail();

        $subQuery = DB::table('accounting_system_users')
                ->select('accounting_system_id as id', DB::raw('COUNT(accounting_system_id) as hasAccess'))
                ->where('subscription_user_id', $subscription_access->id)
                ->groupBy('accounting_system_id');

        $result = AccountingSystem::select(
                'accounting_systems.*',
                DB::raw('IFNULL(t.hasAccess, 0) as hasAccess')
            )   
            ->where('subscription_id', $subscription->id)
            ->leftJoinSub($subQuery, 't', function($join){
                $join->on('t.id', '=', 'accounting_systems.id');
            })
            ->where('t.hasAccess', '>', 0)
            ->get();

        return $result;
    }

    public function ajaxAddAccess(SubscriptionUser $subscriptionUser, AddAccountingSystemAccessRequest $request)
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

    public function ajaxEditUser(SubscriptionUser $subscriptionUser)
    {
        $subscriptionUser->user;
        $subscriptionUser->subscription;
        $subscriptionUser->accountingSystemAccess;
        return $subscriptionUser;
    }

    public function ajaxUpdateUser(SubscriptionUser $subscriptionUser, Request $request)
    {
        // $current = AccountingSystemUser::where('subscription_user_id', $subscriptionUser->id)->get();

        $current = AccountingSystemUser::where('subscription_user_id', $subscriptionUser->id)
            ->leftJoin('accounting_systems', 'accounting_systems.id', '=', 'accounting_system_users.accounting_system_id')
            ->leftJoin('subscription_users', 'subscription_users.id', '=', 'accounting_system_users.subscription_user_id')
            ->leftJoin('subscriptions', 'subscriptions.id', '=', 'subscription_users.subscription_id')
            ->select(
                'accounting_system_users.id as id', 
                'subscription_users.id as subscription_user_id',
                'accounting_systems.id as accounting_system_id', 
                'accounting_systems.name as accounting_system_name', 
                'subscriptions.id as subscription_id',
            )
            ->get();
        $added = [];
        $reviewed = [];

        $subscriptionUser->role = $request->role;
        $subscriptionUser->save();

        // this is used as the length of the loop
        $m = isset($current) ? count($current) : 0;
        $n = isset($request->accounting_systems) ? count($request->accounting_systems) : 0;

        for($i = 0; $i < $n; $i++) {
            $test[] = $request->accounting_systems[$i];
        }

        // Add new access
        for($i = 0; $i < $n; $i++) {
            $found = false;
            $reviewed[] = $request->accounting_systems[$i];
            for($j = 0; $j < $m; $j++) {
                if($current[$j]->accounting_system_id == $request->accounting_systems[$i]) {
                    $found = true;
                    break;
                }
            }

            if(!$found)
            {
                $new = AccountingSystemUser::create([
                    'accounting_system_id' => $request->accounting_systems[$i],
                    'subscription_user_id' => $subscriptionUser->id,
                ]);
                $added[] = $new;
    
                // Add all permissions
                for($j = 1; $j <= 24; $j++)
                {
                    $permissions[] = [
                        'accounting_system_user_id' => $new->id,
                        'access_level' => 'rw',
                        'sub_module_id' => $j,
                    ];
                }

                DB::table('permissions')->insert($permissions);
            }

        }

        // Remove access
        for($i = 0; $i < $m; $i++) {
            $found = false;
            for($j = 0; $j < $n; $j++) {
                if($current[$i]->accounting_system_id == $request->accounting_systems[$j]) {
                    $found = true;
                    break;
                }
            }
            if(!$found) {
                // check if authenticated user has access to this accounting system. if the authenticated user
                // doesn't, this user's access to this accounting system will remain as is.
                $subscription_access = SubscriptionUser::where('user_id', auth()->id())
                    ->where('subscription_id', $current[$i]->subscription_id)
                    ->first();

                $subQuery = DB::table('accounting_system_users')
                        ->select('accounting_system_id as id', DB::raw('COUNT(accounting_system_id) as hasAccess'))
                        ->where('subscription_user_id', $subscription_access->id)
                        ->groupBy('accounting_system_id');

                $result = AccountingSystem::select(
                        'accounting_systems.*',
                        DB::raw('IFNULL(t.hasAccess, 0) as hasAccess')
                    )   
                    ->where('subscription_id', $current[$i]->subscription_id)
                    ->where('accounting_systems.id', $current[$i]->accounting_system_id)
                    ->leftJoinSub($subQuery, 't', function($join){
                        $join->on('t.id', '=', 'accounting_systems.id');
                    })
                    ->first();

                if(!$result || $result->hasAccess == 0) {
                    continue;
                }              

                // if authenticated user actually has access to this accounting system, then he/she can
                // revoke this user access to this accounting system.
                $removed[] = $current[$i];
                $current[$i]->permissions()->delete();
                $current[$i]->delete();
            }
        }

        return [
            'current' => $current,
            'request' => $request->accounting_systems,
            'reviewed' => isset($reviewed) ? $reviewed : [],
            'added' => isset($added) ? $added : [],
            'removed' => isset($removed) ? $removed : null,
            'test_count' => isset($request->accounting_systems) ? count($request->accounting_systems) : 0,
        ];
    }

    public function ajaxRemoveUser(SubscriptionUser $subscriptionUser)
    {
        // Get accounting systems and permissions the user has access
        $as_user = AccountingSystemUser::where('subscription_user_id', $subscriptionUser->id)->get();
        for($i = 0; $i < count($as_user); $i++) {
            $as_user[$i]->permissions()->delete();
            $as_user[$i]->delete();
        }

        // Remove subscription user
        $subscriptionUser->delete();

        return response()->json([
            'success' => true,
        ]);
    }
}
