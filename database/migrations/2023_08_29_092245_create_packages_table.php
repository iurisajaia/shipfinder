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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->enum('danger_status' , ['ADR 1', 'ADR 2', 'ADR 3', 'ADR 4', 'ADR 5', 'ADR 6', 'ADR 7', 'ADR 8', 'ADR 9', 'ADR 10',])->nullable();
            $table->integer('weight')->nullable();
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->integer('length')->nullable();
            $table->integer('temp')->nullable();
            $table->integer('pcs')->nullable();
            $table->unsignedBigInteger('package_type_id')->nullable();
            $table->foreign('package_type_id')->references('id')->on('package_types')->onDelete('cascade');
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
        Schema::dropIfExists('packages');
    }
};
