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
        Schema::create('employment_advertisement', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('uid');
            $table->text('title');
            $table->bigInteger('cat');
            $table->bigInteger('proficiency');
//            $table->json('personal_proficiency');
            $table->string('city');
            $table->string('cooperation_type');
            $table->string('minimum_salary');
            $table->string('gender');
            $table->text('content_text')->nullable();
            $table->json('head_hunt_recommended')->nullable();
            $table->json('expert_ads_recommended')->nullable();
            $table->string('status');
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
        Schema::dropIfExists('employment_advertisement');
    }
};
