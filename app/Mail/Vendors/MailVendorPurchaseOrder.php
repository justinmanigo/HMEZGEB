<?php

namespace App\Mail\Vendors;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailVendorPurchaseOrder extends Mailable implements ShouldQueue
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
        return $this->markdown('vendors.bills.purchase_order.mail')
            ->subject('Purchase Order')
            ->with([
                'purchase_order' => $this->purchase_order,
            ]);
    }
}
