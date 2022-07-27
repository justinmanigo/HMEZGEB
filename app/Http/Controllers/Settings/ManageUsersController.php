<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Actions\GetAccountingSystemUserPermissions;
use App\Http\Controllers\Controller;
use App\Models\AccountingSystemUser;
use App\Models\User;
use App\Models\Settings\Users\Module;
use App\Models\Settings\Users\SubModule;
use App\Models\Settings\Users\Permission;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailSettingUser;


class ManageUsersController extends Controller
{
    /**
     * Manage Users Page
     */
    public function index()
    {
        $accountingSystemUsers = AccountingSystemUser::select(
                'accounting_system_users.id as accounting_system_user_id',
                'users.firstName',
                'users.lastName',
                'users.email',
                'accounting_system_users.role',
                // TODO: Add Status and Last Logged In
            )
            ->leftJoin('users', 
            'users.id', '=', 'accounting_system_users.user_id')
            ->where('accounting_system_id', $this->request->session()->get('accounting_system_id'))
            ->get();

        return view('settings.users.manageUsers.index', [
            'accountingSystemUsers' => $accountingSystemUsers,
        ]);
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
}