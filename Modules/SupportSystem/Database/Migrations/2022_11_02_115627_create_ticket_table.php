<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Users\Entities\Users;
use Modules\SupportSystem\Entities\SupportSystem;

return new class extends Migration
{

    /* Relationship to User */
    public function user_tbl()
    {
        return $this->belongsTo(Users::class, 'uid', 'id');
    }

    /* Relationship to Support */
    public function support_tbl()
    {
        return $this->belongsTo(SupportSystem::class, 'support_id', 'id');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('uid');
            $table->bigInteger('support_id');
            $table->longText('replay_text');
            $table->json('attachments')->nullable();
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
        Schema::dropIfExists('ticket');
    }
};
