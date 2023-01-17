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
        Schema::table('job_posts', function (Blueprint $table) {
            $table->integer('meta_description')->change();
            $table->renameColumn('meta_description','major_id');
            $table->integer('remote')->change();
            $table->renameColumn('remote','level');
            $table->decimal('min_salary')->nullable()->change();
            $table->decimal('max_salary')->nullable()->change();
            $table->integer('experience')->comment('0:null,1:<1,2:1exp,3:2exp,4:3exp,5:4exp,6:5exp,7:>5')->change();
            $table->integer('amount');
            $table->integer('type_work')->comment('0:intern,1:parttime,2:full');
            $table->integer('gender')->comment('0:null,1:male,2:female');
            $table->text('benefits');
            $table->text('description')->change();
            $table->text('requirement')->change();
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
