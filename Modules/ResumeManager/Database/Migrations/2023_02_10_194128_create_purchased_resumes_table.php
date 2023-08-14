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
        Schema::create('purchased_resumes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('buyer_id');
            $table->bigInteger('resume_id');
            $table->bigInteger('amount');
            $table->string('result')->nullable();
            $table->json('reasons')->nullable();
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
        Schema::dropIfExists('purchased_resumes');
    }
};
