<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('accounting_system_id')->constrained();
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->boolean('resolved')->default(false);
            $table->timestamp('time_resolved')->nullable();
            $table->string('link')->nullable();
            $table->enum('type', [
                'info',
                'success',
                'warning',
                'danger',
            ]);
            $table->string('source')->nullable();
            $table->string('title')->nullable();
            $table->string('message')->nullable();
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
        Schema::dropIfExists('notifications');
    }
}
