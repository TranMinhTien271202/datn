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
        Schema::create('seeker_profile', function (Blueprint $table) {
            $table->id();
            $table->integer('candidate_id');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('name');
            $table->string('position_candidate');
            $table->string('coin');
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
        Schema::dropIfExists('candidate_profile');
    }
};
