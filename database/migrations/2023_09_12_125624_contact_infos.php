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
        Schema::create('contact_infos', function (Blueprint $table) {
            $table->timestamps();
            $table->string('contact_person_firstname')->nullable();
            $table->string('contact_person_lastname')->nullable();
            $table->string('contact_person_phone')->nullable();
            $table->boolean('is_sender')->default(true)->nullable();
            $table->unsignedBigInteger('package_id');
            $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade');
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
