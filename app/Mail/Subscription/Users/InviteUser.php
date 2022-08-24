<?php

namespace App\Mail\Subscription\Users;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InviteUser extends Mailable implements ShouldQueue 
{
    use Queueable, SerializesModels;

    private $subscription;
    private $owner;
    private $role;
    private $user;
    private $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subscription_id, $role, $user, $rawPassword)
    {
        $this->subscription = Subscription::where('subscriptions.id', $subscription_id)->first();
        $this->owner = User::where('id', $this->subscription->user_id)->first();
        $this->role = $role;
        $this->user = $user;
        $this->password = $rawPassword;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('subscription.users.mail.invite-user', [
            'subscription' => $this->subscription,
            'owner' => $this->owner,
            'role' => $this->role,
            'user' => $this->user,
            'password' => $this->password
        ])
        ->subject('User Invitation');
    }
}
