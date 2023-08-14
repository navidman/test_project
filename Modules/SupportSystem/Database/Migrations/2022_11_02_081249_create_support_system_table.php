<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('support_system', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('uid');
            $table->string('title');
            $table->bigInteger('department');
            $table->string('priority');
            $table->longText('ticket_content');
            $table->json('attachments')->nullable();
            $table->string('status');
            $table->bigInteger('created_by');
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
        Schema::dropIfExists('support_system');
    }
};
