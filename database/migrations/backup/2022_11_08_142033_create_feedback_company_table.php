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
        Schema::create('feedback_company', function (Blueprint $table) {
            $table->id();
            $table->integer('candidate_id');
            $table->integer('company_id');
            $table->tinyInteger('rate');
            $table->string('comment');
            $table->string('satisfied');
            $table->string('unsatisfied');
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
        Schema::dropIfExists('feedback_company');
    }
};
