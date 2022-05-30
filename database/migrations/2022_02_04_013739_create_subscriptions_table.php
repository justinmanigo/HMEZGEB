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
            $table->foreignId('referral_id')->nullable()->constrained();
            $table->tinyInteger('account_limit')->default(3);
            $table->enum('account_type', [
                'super admin',
                'admin',
                'moderator',
                'member',
            ])->default('admin');
            $table->date('date_from')->nullable()->default(now()->format('Y-m-d'));
            $table->date('date_to')->nullable()->default(now()->addWeek()->format('Y-m-d'));
            $table->enum('status', [ 
                'unused',
                'trial',
                'active',
                'expired',
            ])->nullable()->default('unused');
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
