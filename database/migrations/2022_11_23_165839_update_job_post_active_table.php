<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_post_activities', function (Blueprint $table) {
            $table->integer('company_id');
            $table->integer('job_post_id')->nullable()->change();
            $table->time('time')->nullable();
            $table->integer('is_function')->comment('0:job_post,1:job_speed,2:opencv');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
