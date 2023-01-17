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
        Schema::table('companies', function (Blueprint $table) {
            $table->string('company_name')->nullable()->change();
            $table->string('address')->nullable()->change();
            $table->string('district')->nullable()->change();
            $table->string('company_model')->nullable()->change();
            $table->string('working_time')->nullable()->change();
            $table->string('city')->nullable()->change();
            $table->string('country')->nullable()->change();
            $table->string('zipcode')->nullable()->change();
            $table->string('logo')->nullable()->change();
            $table->string('link_web')->nullable()->change();
            $table->integer('coin')->default(0)->change();
            $table->string('tax_code')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
};
