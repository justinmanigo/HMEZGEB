<?php

namespace App\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class CheckDuplicateSubModulePermission
{
    use AsAction;

    public function handle($duplicate_sub_module_id)
    {
        if($duplicate_sub_module_id == null)
            return false;

        return User::find(Auth::user()->id)->permissions()
            ->where('sub_module_id', '=', $duplicate_sub_module_id)
            ->count();
    }
}
