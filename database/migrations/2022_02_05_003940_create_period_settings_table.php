<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeriodSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('period_settings', function (Blueprint $table) {
            $table->id();
            // The accounting system this setting belongs.
            $table->foreignId('accounting_system_id')->constrained();
            // Gregorian: Date From
            $table->integer('month_from')->nullable();
            $table->integer('day_from')->nullable();
            // Gregorian: Date To
            $table->integer('month_to')->nullable();
            $table->integer('day_to')->nullable();
            // Gregorian: Date From (Leap)
            $table->integer('month_from_leap')->nullable();
            $table->integer('day_from_leap')->nullable();
            // Gregorian: Date To (Leap)
            $table->integer('month_to_leap')->nullable();
            $table->integer('day_to_leap')->nullable();
            // Ethiopian: Date From
            $table->integer('month_from_ethiopian')->nullable();
            $table->integer('day_from_ethiopian')->nullable();
            // Ethiopian: Date To
            $table->integer('month_to_ethiopian')->nullable();
            $table->integer('day_to_ethiopian')->nullable();
            // Ethiopian: Date From (Leap)
            $table->integer('month_from_leap_ethiopian')->nullable();
            $table->integer('day_from_leap_ethiopian')->nullable();
            // Ethiopian: Date To (Leap)
            $table->integer('month_to_leap_ethiopian')->nullable();
            $table->integer('day_to_leap_ethiopian')->nullable();
            // User who last updated the period setting
            $table->foreignId('accounting_system_user_id')->constrained();
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
        Schema::dropIfExists('period_settings');
    }
}
