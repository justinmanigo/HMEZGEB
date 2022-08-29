<?php

namespace App\Mail\Control\Subscription;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SuspendSubscription extends Mailable implements ShouldQueue 
{
    use Queueable, SerializesModels;

    private $owner;
    private $subscription;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($owner, $subscription)
    {
        $this->owner = $owner;
        $this->subscription = $subscription;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('control_panel.subscriptions.mail.suspend', [
            'owner' => $this->owner,
            'subscription' => $this->subscription,
        ])
        ->subject('Suspend Subscription');
    }
}
