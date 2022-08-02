<?php

namespace App\Http\Controllers;

use App\Actions\CreateAccountingSystem;
use App\Http\Requests\Control\AddExistingUserAsSuperAdmin;
use App\Http\Requests\Control\AddNewSuperAdminRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Kaiopiola\Keygen\Key;

class ControlPanelController extends Controller
{
    public function index()
    {
        // Query Super Admins
        $super_admins = User::where('control_panel_role', '!=', NULL)
            ->where('id', '!=', Auth::user()->id)
            ->where('id', '!=', 1)
            ->get();

        return view('control_panel.index', [
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

        $user->control_panel_role = $request->control_panel_role;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'User has been invited to the control panel.',
            'user' => $user
        ]);
    }
    

    /**
     * AJAX endpoint to add a new super admin user account.
     */
    public function addNewSuperAdmin(AddNewSuperAdminRequest $request)
    {
        $exampleKey = new Key;
        $exampleKey->setPattern("XXXXXXXX");

        $user = User::create([
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'control_panel_role' => $request->control_panel_role,
            'code' => (string)$exampleKey->generate(),
            'username' => (string)$exampleKey->generate(),
        ]);

        return $user;
    }

    /**
     * AJAX endpoint to add an existing user as a super admin.
     */
    public function addExistingUserAsSuperAdmin(AddExistingUserAsSuperAdmin $request)
    {
        $user = User::findOrFail($request->user->value);
        $user->control_panel_role = $request->control_panel_role;
        $user->save();

        return $user;
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
