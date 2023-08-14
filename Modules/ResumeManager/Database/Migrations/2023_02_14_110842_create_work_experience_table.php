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
        Schema::create('work_experience', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('resume_id');
            $table->string('full_name');
            $table->string('email');
            $table->string('phone');
            $table->string('company_name');
            $table->string('cooperation_period');
            $table->string('cooperation_type');
            $table->string('linkedin')->nullable();
            $table->string('linkedin_status')->nullable();
            $table->text('experience_message')->nullable();
            $table->string('status');
            $table->longText('key');
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
        Schema::dropIfExists('work_experience');
    }
};
