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
        Schema::create('request_replies', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('uid');
            $table->bigInteger('request_id');
            $table->longText('content_text');
            $table->bigInteger('attachments')->nullable();
            $table->bigInteger('voice')->nullable();
            $table->string('need_to_answer')->nullable();
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
        Schema::dropIfExists('request_replies');
    }
};
