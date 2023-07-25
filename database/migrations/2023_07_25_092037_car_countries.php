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
        Schema::create('car_countries', function (Blueprint $table) {
            $table->unsignedBigInteger('car_id')->unsigned();

            $table->unsignedBigInteger('country_id')->unsigned();

            $table->foreign('car_id')->references('id')->on('cars')

                ->onDelete('cascade');

            $table->foreign('country_id')->references('id')->on('countries')

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
