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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('company_name');
            $table->string('address');
            $table->string('district');
            $table->string('company_model');
            $table->string('working_time');
            $table->string('city');
            $table->string('country');
            $table->string('zipcode');
            $table->string('phone');
            $table->string('email');
            $table->string('password');
            $table->string('logo');
            $table->string('link_web');
            $table->integer('coin');
            $table->string('tax_code');
            $table->integer('status')->default(1)->comment('0:pending, 1:active ,2:block');
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
        Schema::dropIfExists('companies');
    }
};
