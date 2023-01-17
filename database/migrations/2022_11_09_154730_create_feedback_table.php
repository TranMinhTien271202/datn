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
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->integer('candidate_id');
            $table->integer('company_id');
            $table->tinyInteger('rate');
            $table->string('comment');
            $table->string('satisfied')->nullable();
            $table->string('unsatisfied')->nullable();
            $table->integer('is_candidate')->comment('0:feedback candidate, 1:feedback company');
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
        Schema::dropIfExists('feedback');
    }
};
