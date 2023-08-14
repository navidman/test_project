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
        Schema::create('question_center', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('uid');
            $table->text('title');
            $table->text('slug');
            $table->longText('content_text')->nullable();
            $table->bigInteger('cat')->nullable();
            $table->integer('rate')->default(0)->nullable();
            $table->text('status');
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
        Schema::dropIfExists('question_center');
    }
};
