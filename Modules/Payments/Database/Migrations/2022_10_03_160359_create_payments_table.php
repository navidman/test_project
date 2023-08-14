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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('uid')->nullable();
            $table->string('title');
            $table->string('product_type');
            $table->bigInteger('product_id')->nullable();
            $table->integer('discount_amount')->nullable();
            $table->integer('amount');
            $table->integer('payment_amount')->nullable();
            $table->bigInteger('discount_id')->nullable();
            $table->text('order_description')->nullable();
            $table->json('order_meta')->nullable();
            $table->string('gateway')->nullable();
            $table->string('currency')->nullable();
            $table->string('transaction_id')->nullable();
            $table->text('transaction_result')->nullable();
            $table->integer('viewed')->default(0)->nullable();
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
        Schema::dropIfExists('payments');
    }
};
