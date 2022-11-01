<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();

            // Foreign
            $table->foreignId('payment_reference_id')->constrained('payment_references');
            $table->foreignId('withholding_payment_id')->nullable()->constrained('withholding_payments');

            // Fields
            $table->string('reference_number')->nullable();

            // Auto generated fields
            $table->decimal('sub_total', 18, 8);
            $table->decimal('discount', 18, 8);
            $table->decimal('tax', 18, 8);
            $table->decimal('grand_total', 18, 8);
            $table->decimal('withholding', 18, 8);
            $table->enum('withholding_status', [
                'paid',
                'unpaid',
                'partially_paid',
            ])->default('unpaid');
            $table->enum('payment_method', [
                'cash',
                'credit',
            ]);
            $table->decimal('amount_received', 18, 8);
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
        Schema::dropIfExists('expenses');
    }
}
