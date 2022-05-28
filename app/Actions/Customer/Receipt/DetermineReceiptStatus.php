<?php

namespace App\Actions\Customer\Receipt;

use Lorisleiva\Actions\Concerns\AsAction;

class DetermineReceiptStatus
{
    use AsAction;

    public function handle($grand_total, $total_amount_received)
    {
        if($grand_total == $total_amount_received) {
            return 'paid';
        }
        else if($total_amount_received > 0) {
            return 'partially_paid';
        }
        else {
            return 'unpaid';
        }
    }
}
