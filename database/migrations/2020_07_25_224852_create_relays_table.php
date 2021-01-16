<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relay', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('desc',300)->default("")->comment('简介');
            $table->string('url','300')->default('')->comment('跳转地址');
            $table->string('photo','300')->default('images/Koala.jpg')->comment('图片');
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
        Schema::dropIfExists('relay');
    }
}
