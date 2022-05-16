<?php

namespace App\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Support\Facades\Auth;
use App\Models\AccountingSystemUser;

class CheckDuplicateSubModulePermission
{
    use AsAction;

    public function handle($accounting_system_user_id, $duplicate_sub_module_id)
    {
        if($duplicate_sub_module_id == null)
            return false;

        return AccountingSystemUser::find($accounting_system_user_id)->permissions()
            ->where('sub_module_id', '=', $duplicate_sub_module_id)
            ->count();
    }
}
