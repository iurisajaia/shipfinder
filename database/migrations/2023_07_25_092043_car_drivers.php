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
        Schema::create('car_drivers', function (Blueprint $table) {
            $table->unsignedBigInteger('car_id')->unsigned();

            $table->unsignedBigInteger('user_id')->unsigned();

            $table->foreign('car_id')->references('id')->on('cars')

                ->onDelete('cascade');

            $table->foreign('user_id')->references('id')->on('users')

                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
