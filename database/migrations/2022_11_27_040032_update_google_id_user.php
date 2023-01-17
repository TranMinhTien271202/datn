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
        Schema::table('candidates', function (Blueprint $table) {
            $table->string('google_id')->nullable();
            $table->string('password')->nullable()->change();
            $table->integer('phone')->nullable()->change();
        });
        Schema::table('companies', function (Blueprint $table) {
            $table->string('google_id')->nullable();
            $table->integer('phone')->nullable()->change();
            $table->string('password')->nullable()->change();
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
