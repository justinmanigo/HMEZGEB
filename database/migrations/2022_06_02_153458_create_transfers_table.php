<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('accounting_system_id')->constrained();
            $table->unsignedBigInteger('from_account_id');
            $table->unsignedBigInteger('to_account_id');
            $table->decimal('amount', 18, 8)->nullable();
            $table->string('reason')->nullable();
            $table->enum('status', ['completed', 'void'])->default('completed');
            $table->foreignId('journal_entry_id')->nullable()->constrained();
            $table->foreignId('transaction_id')->nullable()->constrained();

            $table->foreign('from_account_id')->references('id')->on('bank_accounts');
            $table->foreign('to_account_id')->references('id')->on('bank_accounts');
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
        Schema::dropIfExists('transfers');
    }
}
