<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Actions\GetUserPermissions;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Settings\Users\Module;
use App\Models\Settings\Users\SubModule;
use App\Models\Settings\Users\Permission;

class ManageUsersController extends Controller
{
    /**
     * Manage Users Page
     */
    public function index()
    {
        return view('settings.users.manageUsers.index');
    }

    /**  
     * @param \App\Models\User $user
     * @return \Illuminate\Contracts\View\View
     */   
    public function editPermissions(User $user)
    {
        // Get modules
        $modules = Module::get();
        $permissions = GetUserPermissions::run($modules, $user);

        return view('settings.users.manageUsers.editPermissions', [
            'user_id' => $user->id,
            'modules' => $modules,
            'permissions' => $permissions
        ]);
    }

    public function updatePermissions(Request $request, User $user)
    {
        // Delete existing permissions of user.
        $user->permissions()->delete();

        // Insert updated permissions of user.
        for($i = 0; $i < count($request->access_level); $i++)
        {
            // Don't create entries if access level is set to none.
            if($request->access_level[$i] == 'none') continue;

            Permission::create([
                'user_id' => $user->id,
                'sub_module_id' => $request->submodule_id[$i],
                'access_level' => $request->access_level[$i],
                'accounting_system_id' => 1, // TODO: Change this later.
            ]);
        }

        return redirect()->back()->with('success', 'Successfully updated permissions.');
    }
}