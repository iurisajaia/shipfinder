<?php

use App\Enums\StatusEnum;
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
        Schema::create('cargos', function (Blueprint $table) {
            $table->id();
            $table->longText('description')->nullable();
            $table->enum('status', StatusEnum::getValues())->default(StatusEnum::PENDING);

            // location
            $table->json('from')->nullable();
            $table->json('to')->nullable();

            // schedules
            $table->string('pick_up_date')->nullable();
            $table->string('delivery_date')->nullable();
            // contact

            // bidding
            $table->integer('price')->nullable();
            $table->string('bidding_end_date')->nullable();
            $table->boolean('date_offer')->default(false)->nullable();


            // relations
            $table->unsignedBigInteger('package_id');
            $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->foreign('driver_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('carrgos');
    }
};
