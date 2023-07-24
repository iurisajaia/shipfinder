<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->string('password')->nullable();
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('company_id')->nullable();
            $table->integer('carrier_id')->nullable();
            $table->string('company_name')->nullable();
            $table->string('temp_password')->nullable();
            $table->integer('user_role_id')->nullable();
            $table->integer('driver_info_id')->nullable();
            $table->string('phone')->unique()->nullable();
            $table->string('email')->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->boolean('user_logged_in')->nullable()->default(false);
            $table->boolean('user_data_is_verified')->nullable()->default(false);
            $table->rememberToken();
            $table->timestamps();
        });

//        \DB::statement("UPDATE users SET password = NULL WHERE user_role_id = 6");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::table('users', function (Blueprint $table) {
//            $table->string('password')->nullable(false)->change();
//        });
        Schema::dropIfExists('users');
    }
};
