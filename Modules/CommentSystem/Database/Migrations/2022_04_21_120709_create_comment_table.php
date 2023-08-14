<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comment', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('uid')->nullable();
            $table->string('name');
            $table->text('url')->nullable();
            $table->string('email');
            $table->string('post_type');
            $table->bigInteger('post_id');
            $table->bigInteger('parent_id')->nullable();
            $table->string('status');
            $table->longText('message');
            $table->bigInteger('like')->nullable();
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
        Schema::dropIfExists('comment');
    }
};
