<?php

namespace App\Http\Controllers\AccountSettings;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUsernameRequest;
use App\Http\Requests\UpdateEmailRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Models\User;
use App\Models\Module;
use App\Models\Permission;

class ManageUsersController extends Controller
{
    /**
     * Manage Users Page
     */
    public function index()
    {
        return view('account.manageUsers.index');
    }

    /**  
     * SQL Query for getting current users' permissions:
     * 
     * select `sub_modules`.`id`, `sub_modules`.`name`, `t`.`access_level` 
     * from `sub_modules`
     * left join ( 
     *  select `permissions`.`user_id`, `sub_modules`.`id`
     *  from `sub_modules` 
     *  left join `permissions` on `permissions`.`sub_module_id` = `sub_modules`.`id` 
     *  where `permissions`.`user_id` = 2 
     * ) as t on t.id = sub_modules.id
     * where `sub_modules`.`module_id` = 3
     * and `sub_modules`.`duplicate_sub_module_id` is null
     * 
     * @param \App\Models\User $user
     * @return \Illuminate\Contracts\View\View
     */   
    public function editPermissions(User $user)
    {
        // Initialize subquery
        $subQuery = DB::table('sub_modules')
            ->select('permissions.access_level', 'sub_modules.id')
            ->leftJoin('permissions', 'permissions.sub_module_id', '=', 'sub_modules.id')
            ->where('permissions.user_id', $user->id);

        // Get modules
        $modules = Module::get();

        // Iterate each module for submodules while getting the user's
        // current permission values
        for($i = 0; $i < count($modules); $i++)
            $permissions[$i] = $modules[$i]->subModules()
                ->select('sub_modules.id', 'sub_modules.name', 't.access_level')
                ->leftJoinSub($subQuery, 't', function($join){
                    $join->on('t.id', '=', 'sub_modules.id');
                })->where('sub_modules.duplicate_sub_module_id', '=', null)
                ->orderBy('sub_modules.id', 'ASC')
                ->get();

        return view('account.manageUsers.editPermissions', [
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
            ]);
        }

        return redirect()->back()->with('success', 'Successfully updated permissions.');
    }
}