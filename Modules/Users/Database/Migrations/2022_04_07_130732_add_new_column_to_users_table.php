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
        Schema::table('users', function (Blueprint $table) {
            $table->string('full_name')->after('id');
            $table->string('company_name_fa')->nullable()->after('full_name');
            $table->string('company_name_en')->nullable()->after('company_name_fa');
            $table->string('organization_level')->nullable()->after('company_name_en');
            $table->string('economic_code')->nullable()->after('organization_level');
            $table->string('organization_phone')->nullable()->after('economic_code');
            $table->string('province')->nullable()->after('company_name_en');
            $table->string('city')->nullable()->after('province');
            $table->string('phone')->unique()->nullable()->after('city');
            $table->string('website')->nullable()->after('phone');
            $table->json('company_activity')->nullable()->after('website');
            $table->string('number_of_staff')->nullable()->after('company_activity');
            $table->string('job_group')->nullable()->after('number_of_staff');
            $table->text('biography')->nullable()->after('job_group');
            $table->string('gender')->nullable()->after('biography');
            $table->bigInteger('avatar')->nullable()->after('gender');
            $table->bigInteger('cover_image')->nullable()->after('avatar');
            $table->bigInteger('official_newspaper')->nullable()->after('avatar');
            $table->string('role')->after('avatar');
            $table->string('parent_id')->after('role')->nullable();
            $table->string('panel_access')->after('parent_id')->nullable();
            $table->string('district')->after('panel_access')->nullable();
            $table->bigInteger('shaba')->after('district')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {

        });
    }
};
