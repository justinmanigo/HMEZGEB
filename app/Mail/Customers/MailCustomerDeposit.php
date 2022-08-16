<?php

namespace App\Mail\Customers;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailCustomerDeposit extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $deposit;
    public function __construct($deposit)
    {
        //
        $this->deposit = $deposit;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('customer.deposit.mail')
                    ->with([
                        'deposit' => $this->deposit,
                    ]);
    }
}
