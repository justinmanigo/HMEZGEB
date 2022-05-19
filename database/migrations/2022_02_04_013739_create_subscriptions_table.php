<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->tinyInteger('account_limit')->default(3);
            $table->enum('account_type', [      // this part is something to be clarified
                'admin',                        // later on in the progress meeting with
                'moderator',                    // the client.
                'member',
            ])->default('admin');
            $table->date('trial_from')->nullable()->default(now()->format('Y-m-d'));
            $table->date('trial_to')->nullable()->default(now()->addWeek()->format('Y-m-d'));
            $table->enum('payment_status', [ 
                'pending',
                'paid',
            ])->nullable()->default('pending');
            $table->timestamp('active_since_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscriptions');
    }
}
