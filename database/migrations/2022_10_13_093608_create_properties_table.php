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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id");
            $table->string("name", 100);
            $table->string('building_name')->nullable();
            $table->string("domicile", 255)->nullable();
            $table->string("address", 255)->nullable();
            $table->unsignedInteger("price"); // Corrected data type to unsignedInteger
            $table->integer("capacity");
            $table->text("description");
            $table->boolean("status");
            $table->timestamps();

            $table->foreign("user_id")->references("id")->on("users");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('properties');
    }
};
