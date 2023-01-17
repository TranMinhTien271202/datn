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
        Schema::create('job_posts', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id');
            $table->string('title');
            $table->integer('major_id');
            $table->integer('level');
            $table->decimal('min_salary')->nullable();
            $table->decimal('max_salary')->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->integer('experience')->comment('0:null,1:<1,2:1exp,3:2exp,4:3exp,5:4exp,6:5exp,7:>5');
            $table->integer('amount');
            $table->integer('type_work')->comment('0:intern,1:parttime,2:full');
            $table->integer('gender')->comment('0:null,1:male,2:female');
            $table->text('benefits')->nullable();
            $table->text('description')->nullable();
            $table->text('requirement')->nullable();
            $table->integer('area');
            $table->string('address');
            $table->integer('status')->default(1)->comment('0:block, 1:active');
            $table->softDeletes();
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
        Schema::dropIfExists('job_posts');
    }
};
