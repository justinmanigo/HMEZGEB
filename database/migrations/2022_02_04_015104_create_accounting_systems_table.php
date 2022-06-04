<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountingSystemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounting_systems', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subscription_id')->nullable()->constrained();
            $table->enum('calendar_type', [
                'gregorian',
                'ethiopian',
            ]);
            $table->integer('accounting_year');
            $table->string('name');
            $table->mediumText('address');
            $table->string('po_box')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('city');
            $table->string('country')->nullable();
            $table->string('mobile_number');
            $table->string('telephone_1')->nullable();
            $table->string('telephone_2')->nullable();
            $table->string('fax')->nullable();
            $table->mediumText('website')->nullable();
            $table->string('vat_number')->nullable();
            $table->string('tin_number');
            $table->string('contact_person');
            $table->string('contact_person_position');
            $table->string('contact_person_mobile_number');
            $table->enum('business_type', [
                'Sole Proprietorship',
                'Partnership',
                'PLC',
                'Share Company'
            ]);
            $table->enum('settings_inventory_type', [
                'average',
                'lifo',
                'fifo',
            ])->default('average');
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
        Schema::dropIfExists('accounting_systems');
    }
}
