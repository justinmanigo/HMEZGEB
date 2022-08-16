<?php

namespace App\Mail\Customers;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailCustomerReceipt extends Mailable implements ShouldQueue 
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $receipt_items;

    public function __construct($receipt_items)
    {
        $this->receipt_items = $receipt_items;

    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Customer Receipt')
        ->markdown('customer.receipt.mail')->with([
            'receipt_items' => $this->receipt_items
        ]);
    }
}
