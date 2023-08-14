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
        Schema::create('file_library', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('uid');
            $table->text('org_name');
            $table->text('file_name');
            $table->text('path');
            $table->text('extension');
            $table->text('file_type');
            $table->text('used');
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
        Schema::dropIfExists('file_library');
    }
};
