<?php

namespace App\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use App\Models\AccountingSystemUser;

class GetLoggedAccountingSystemUserId
{
    use AsAction;

    public function handle($accounting_system_id, $user_id)
    {
        return AccountingSystemUser::where('accounting_system_id', $accounting_system_id)
            ->where('user_id', $user_id)
            ->first();
    }
}
