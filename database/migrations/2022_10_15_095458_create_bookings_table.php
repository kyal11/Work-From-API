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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('property_id')->nullable(true);
            $table->unsignedBigInteger('user_id')->nullable(true);
            $table->date('booking_date');
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['booked', 'finished', 'canceled']);
            $table->timestamps();
            
        
            $table->foreign('property_id')->on('properties')->references('id');
            $table->foreign('user_id')->on('users')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
};
