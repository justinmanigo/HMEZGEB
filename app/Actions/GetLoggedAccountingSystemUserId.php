<?php

namespace App\Actions;

use App\Models\AccountingSystem;
use Lorisleiva\Actions\Concerns\AsAction;
use App\Models\AccountingSystemUser;
use App\Models\SubscriptionUser;

class GetLoggedAccountingSystemUserId
{
    use AsAction;

    public function handle($accounting_system_id, $subscription_user_id)
    {
        return AccountingSystemUser::select(
                'accounting_system_users.id', 
                'accounting_system_users.subscription_user_id'
            )
            ->leftJoin('accounting_systems', 'accounting_systems.id', '=', 'accounting_system_users.accounting_system_id')
            ->leftJoin('subscriptions', 'subscriptions.id', '=', 'accounting_systems.subscription_id')
            ->leftJoin('subscription_users', 'subscription_users.subscription_id', '=', 'subscriptions.id')
            ->where('accounting_system_users.subscription_user_id', $subscription_user_id)
            ->where('accounting_systems.id', $accounting_system_id)
            ->first();

    }
}
