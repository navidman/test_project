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
        Schema::create('blog', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->text('slug');
            $table->longText('desc')->nullable();
            $table->longText('content_text');
            $table->json('cat')->nullable();
            $table->integer('thumbnail')->nullable();
            $table->integer('author');
            $table->text('status');
            $table->string('time_watch')->nullable();
            $table->string('article_level')->nullable();
            $table->bigInteger('visited')->nullable();
            $table->json('tag')->nullable();
            $table->boolean('featured')->nullable();
            $table->string('publish_at')->nullable();
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
        Schema::dropIfExists('blog');
    }
};
