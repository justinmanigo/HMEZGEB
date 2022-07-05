<?php

namespace App\Http\Controllers;

use App\Actions\CreateAccountingSystem;
use App\Http\Requests\Control\AddNewSuperAdminRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Kaiopiola\Keygen\Key;

class ControlPanelController extends Controller
{
    public function index()
    {
        // Query Super Admins
        $super_admins = User::where('control_panel_role', '!=', NULL)->get();

        return view('control_panel.index', [
            'super_admins' => $super_admins
        ]);
    }

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
}
