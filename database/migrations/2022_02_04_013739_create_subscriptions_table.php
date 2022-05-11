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
            $table->foreignId('user_id')->constrained();
            $table->tinyInteger('account_limit');
            $table->integer('referral_user_id');
            $table->string('referral_code');
            $table->enum('referral_type', [
                'normal',   // for all user types. it works like gcash, like inviting someone
                            // to try out the HMEZGEB system.
                'advanced', // intended for hmezgeb staff where they can customize the referral
                            // based to the client needs.
            ]);
            $table->date('trial_from')->nullable();
            $table->date('trial_to')->nullable();
            // $table->enum('status', [ // this part is yet to be discussed later on.
            //     'unpaid',
            //     'paid',
            // ])->nullable();
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
