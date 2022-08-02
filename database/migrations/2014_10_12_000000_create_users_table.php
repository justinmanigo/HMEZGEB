<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('username')->unique();
            $table->string('firstName')->nullable()->default('New');
            $table->string('lastName')->nullable()->default('User');
            $table->enum('control_panel_role', [
                'staff',
                'admin',
            ])->nullable();
            $table->boolean('is_control_panel_access_accepted')->default(false);
            $table->string('code')->nullable();
            $table->enum('activated',['Yes','No'])->default('Yes');
            $table->rememberToken();
            $table->timestamp('password_updated_at')->nullable();
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
        Schema::dropIfExists('users');
    }
}
