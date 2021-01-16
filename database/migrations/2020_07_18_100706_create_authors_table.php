<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('author', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_name','50')->default('')->comment('登录账户');
            $table->string('user_password','200')->default('')->comment('登录密码');
            $table->string('author_name','100')->default('')->comment('作者名称');
            $table->string('desc','300')->default('')->comment('简介');
            $table->string('certification_mark','400')->default('')->comment('认证标识');
            $table->string('photo','300')->default('images/Koala.jpg')->comment('图像');
            $table->string('field','255')->default('')->comment('擅长领域');
            $table->unsignedTinyInteger('is_hot')->default(0)->comment('是否推荐:0=否，1=是');
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
        Schema::dropIfExists('author');
    }
}
