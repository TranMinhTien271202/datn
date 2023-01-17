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
        Schema::create('seeker_profiles', function (Blueprint $table) {
            $table->id();
            $table->integer('candidate_id');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->integer('major_id')->comment('chuyen nghanh')->nullable();
            $table->string('description')->nullable();
            $table->string('position_candidate')->nullable();
            $table->string('coin')->default(0);
            $table->string('path_cv');
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
        Schema::dropIfExists('seeker_profiles');
    }
};
