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
        Schema::create('car_car_body_types', function (Blueprint $table) {
            $table->unsignedBigInteger('car_id')->unsigned();

            $table->unsignedBigInteger('car_body_type_id')->unsigned();

            $table->foreign('car_id')->references('id')->on('cars')

                ->onDelete('cascade');

            $table->foreign('car_body_type_id')->references('id')->on('car_body_types')

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
