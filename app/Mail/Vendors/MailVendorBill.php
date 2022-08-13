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
    public $bills;
    public function __construct($bills)
    {
        $this->bills = $bills;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('vendors.bills.mail')->with([
            'bills' => $this->bills,
        ]);
    }
}
