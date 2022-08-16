<?php

namespace App\Mail\Customers;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailCustomerAdvanceRevenue extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $advance_revenue;
    public function __construct($advance_revenue)
    {
        $this->advance_revenue = $advance_revenue;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('customer.receipt.advance_revenue.mail')->with([
            'advance_revenue' => $this->advance_revenue,
        ]);
    }
}
