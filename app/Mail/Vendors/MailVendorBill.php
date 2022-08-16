<?php

namespace App\Mail\Vendors;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailVendorBill extends Mailable implements ShouldQueue 
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $bill_items;
    public function __construct($bill_items)
    {
        $this->bill_items = $bill_items;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('vendors.bills.mail')->with([
            'bill_items' => $this->bill_items,
        ]);
    }
}
