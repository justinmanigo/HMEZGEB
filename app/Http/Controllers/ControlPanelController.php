<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
}
