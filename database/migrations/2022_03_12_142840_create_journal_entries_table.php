<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJournalEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journal_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('accounting_system_id')->constrained();
            $table->date('date');
            $table->longtext('notes')->nullable(); 
            // $table->unsignedBigInteger('model_reference_id');     
            // $table->enum('model_reference_name',['customer','vendors','banking']); 
            $table->timestamps();

            // $table->foreign('model_reference_id')->references('id')->on('bank_reconciliations');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('journal_entries');
    }
}
