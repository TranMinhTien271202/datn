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
            $table->string('name')->comment('ten nguoi dai dien')->nullable();
            $table->string('company_name');
            $table->string('address')->nullable();
            $table->string('company_model')->nullable()->comment('loai hinh');
            $table->string('working_time')->nullable();
            $table->string('phone');
            $table->string('email');
            $table->string('password');
            $table->string('logo')->nullable();
            $table->string('link_web')->nullable();
            $table->integer('coin')->default(0);
            $table->string('tax_code')->nullable();
            $table->string('image_paper')->nullable()->comment('anh giay phep');
            $table->integer('status')->default(0)->comment('0:pending, 1:active ,2:block');
            $table->string('team')->nullable()->comment('so luong nhan vien');
            $table->string('about')->nullable()->comment('mo ta');
            $table->date('founded_in')->nullable()->comment('ngay thanh lap');
            $table->string('map')->nullable();
            $table->string('career')->nullable()->comment('linh vuc');
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
