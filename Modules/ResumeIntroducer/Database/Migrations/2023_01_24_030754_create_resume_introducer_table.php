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
        Schema::create('resume_introducer', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('resume_id');
            $table->bigInteger('job_seeker_id');
            $table->bigInteger('employment_id');
            $table->string('recognition');
            $table->string('confidence');
            $table->string('expertise');
            $table->string('personality');
            $table->string('experience');
            $table->string('software');
            $table->string('organizational_behavior');
            $table->string('passion');
            $table->string('salary_rate');
            $table->string('reason_adjustment');
            $table->bigInteger('interview_file')->nullable();
            $table->bigInteger('voice')->nullable();
            $table->longText('comment_employment')->nullable();
            $table->longText('expert_opinion')->nullable();
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
        Schema::dropIfExists('resume_introducer');
    }
};
