<?php

namespace App\Actions\Customer\Receipt;

use Lorisleiva\Actions\Concerns\AsAction;

class DeterminePaymentMethod
{
    use AsAction;

    public function handle($grand_total, $total_amount_received)
    {
        if($grand_total == $total_amount_received) {
            return 'cash';
        }
        else {
            return 'credit';
        }
    }
}
