<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Actions\GetAccountingSystemUserPermissions;
use App\Http\Controllers\Controller;
use App\Models\AccountingSystem;
use App\Models\AccountingSystemUser;
use App\Models\User;
use App\Models\Settings\Users\Module;
use App\Models\Settings\Users\SubModule;
use App\Models\Settings\Users\Permission;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailSettingUser;
use App\Models\Subscription;
use App\Models\SubscriptionUser;
use Illuminate\Support\Facades\DB;
use Kaiopiola\Keygen\Key;

class ManageUsersController extends Controller
{
    /**
     * Manage Users Page
     */
    public function index()
    {
        // Don't include the user who owned the subscription in the list.
        $first_as_user = AccountingSystemUser::where('accounting_system_id', session('accounting_system_id'))->first();

        $accountingSystemUsers = AccountingSystemUser::select(
                'accounting_system_users.id as accounting_system_user_id',
                'users.firstName',
                'users.lastName',
                'users.email',
                'subscription_users.role',
                // TODO: Add Status and Last Logged In
            )
            ->leftJoin('subscription_users', 'subscription_users.id', '=', 'accounting_system_users.subscription_user_id')
            ->leftJoin('users', 
            'users.id', '=', 'subscription_users.user_id')
            ->where('accounting_system_id', $this->request->session()->get('accounting_system_id'))
            ->where('accounting_system_users.id', '!=', $first_as_user->id)
            ->where('accounting_system_users.id', '!=', session('accounting_system_user'))
            ->get();

        return view('settings.users.manageUsers.index', [
            'accountingSystemUsers' => $accountingSystemUsers,
        ]);
    }

    /**
     * 
     */
    public function inviteUser(Request $request)
    {
        $exampleKey = new Key();
        $exampleKey->setPattern('XXXXXXXX');
        $username = strtolower((string)$exampleKey->generate());
        $password = strtolower((string)$exampleKey->generate());

        $user = User::firstOrCreate([
            'email' => $request->email,
        ], [
            'username' => $username,
            'password' => bcrypt($password),
        ]);

        // Get accounting system information
        $accounting_system = AccountingSystem::where('id', session('accounting_system_id'))->first();

        // Get subscription
        $subscription = Subscription::where('id', $accounting_system->subscription_id)->first();

        // Get subscription user
        $subscription_user = SubscriptionUser::updateOrCreate([
            'user_id' => $user->id,
            'subscription_id' => $subscription->id,
        ], [
            'role' => 'member',
            'is_accepted' => false,
        ]);

        // Check if the user is already a member of the accounting system
        $accounting_system_user = AccountingSystemUser::where('accounting_system_id', session('accounting_system_id'))
            ->where('subscription_user_id', $subscription_user->id)
            ->first();

        if($accounting_system_user) {
            // User is already a member of the accounting system
            return redirect()->back()->with('error', 'User is already a member of the accounting system.');
        }

        // Create the accounting system user
        $accounting_system_user = AccountingSystemUser::create([
            'accounting_system_id' => session('accounting_system_id'),
            'subscription_user_id' => $subscription_user->id,
        ]);

        // Add all permissions
        for($j = 1; $j <= 24; $j++)
        {
            $permissions[] = [
                'accounting_system_user_id' => $accounting_system_user->id,
                'access_level' => 'rw',
                'sub_module_id' => $j,
            ];
        }

        DB::table('permissions')->insert($permissions);

        return redirect()->back()->with('success', 'User has been invited successfully.');
    }

    /**  
     * @param \App\Models\AccountingSystemUser $accountingSystemUser
     * @return \Illuminate\Contracts\View\View
     */   
    public function editPermissions(AccountingSystemUser $accountingSystemUser)
    {
        // Get modules
        $modules = Module::get();
        $permissions = GetAccountingSystemUserPermissions::run($modules, $accountingSystemUser->id);

        return view('settings.users.manageUsers.editPermissions', [
            'user_id' => $accountingSystemUser->id,
            'modules' => $modules,
            'permissions' => $permissions
        ]);
    }

    public function updatePermissions(Request $request, AccountingSystemUser $accountingSystemUser)
    {
        // Delete existing permissions of user.
        $accountingSystemUser->permissions()->delete();

        // Insert updated permissions of user.
        for($i = 0; $i < count($request->access_level); $i++)
        {
            // Don't create entries if access level is set to none.
            if($request->access_level[$i] == 'none') continue;

            Permission::create([
                'accounting_system_user_id' => $accountingSystemUser->id,
                'sub_module_id' => $request->submodule_id[$i],
                'access_level' => $request->access_level[$i],
            ]);
        }

        return redirect()->back()->with('success', 'Successfully updated permissions.');
    }

    // Mail
    public function sendMailNewSuperAdmin(AccountingSystemUser $accountingSystemUser)
    {
        // Mail
        $emailAddress = $accountingSystemUser->user->email;
        Mail::to($emailAddress)->send(new MailSettingUser);

        return redirect()->back()->with('success', 'Successfully sent mail.');
    }
    
    public function removeUser(AccountingSystemUser $accountingSystemUser)
    {
        $accountingSystemUser->permissions()->delete();
        $accountingSystemUser->delete();
        return redirect()->back()->with('success', 'Successfully removed user from accounting system.');
    }
}