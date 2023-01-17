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
            $table->string('meta_description');
            $table->string('description');
            $table->string('remote');
            $table->decimal('min_salary');
            $table->decimal('max_salary');
            $table->string('requirement');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('experience');
            $table->integer('status')->default(1)->comment('0:block, 1:active');
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
        Schema::dropIfExists('job_posts');
    }
};
