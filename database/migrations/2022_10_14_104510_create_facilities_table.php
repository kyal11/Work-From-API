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
        Schema::create('facilities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("property_id")->nullable(false);
            $table->string("name",100)->nullable(false);
            $table->integer("qty")->nullable(true);
            $table->text("description")->nullable(true);
            $table->timestamps();

            $table->foreign("property_id")->on("properties")->references("id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fasilities');
    }
};
