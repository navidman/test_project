<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_management', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('uid');
            $table->string('title');
            $table->string('object');
            $table->integer('score')->default(0);
            $table->string('type')->default('receive');
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
        Schema::dropIfExists('order_management');
    }
};
