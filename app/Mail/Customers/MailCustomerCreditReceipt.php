<?php

namespace App\Mail\Customers;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailCustomerCreditReceipt extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $credit_receipt;
    public function __construct($credit_receipt)
    {
        //
        $this->credit_receipt = $credit_receipt;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('customer.receipt.credit_receipt.mail')
        ->with([
            'credit_receipt' => $this->credit_receipt,
        ]);
    }
}
