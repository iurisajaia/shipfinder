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
        Schema::create('trailers', function (Blueprint $table) {
            $table->id();
            $table->string('model')->nullable();
            $table->text('description')->nullable();
            $table->string('registration_number')->nullable();

            $table->unsignedBigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedBigInteger('trailer_type_id')->unsigned();
            $table->foreign('trailer_type_id')->references('id')->on('trailer_types');
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
        Schema::dropIfExists('trailers');
    }
};
