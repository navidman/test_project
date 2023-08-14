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
        Schema::create('resume_manager', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('uid')->nullable();
            $table->string('cooperation_type');
            $table->string('presence_type');
            $table->string('job_position');
            $table->string('level');
            $table->string('sarbazi');
            $table->string('birth_day');
            $table->string('access_resume');
            $table->string('salary');
            $table->string('education')->nullable();
            $table->string('experience')->nullable();
            $table->json('specialty');
            $table->bigInteger('resume_file')->nullable();
            $table->bigInteger('skills');
            $table->string('linkedin')->nullable();
            $table->string('dribbble')->nullable();
            $table->string('status');
            $table->string('job_status')->default('jobless');
            $table->json('requirements')->nullable();
            $table->string('confirm_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resume_manager');
    }
};
