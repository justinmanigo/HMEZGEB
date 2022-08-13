<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailVendorPurchaseOrder extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $purchase_order;
    public function __construct($purchase_order)
    {
        $this->purchase_order = $purchase_order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('vendors.bills.mailPurchaseOrder')
            ->subject('Purchase Order')
            ->with([
                'purchase_order' => $this->purchase_order,
            ]);
    }
}
