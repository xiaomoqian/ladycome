<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassifiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classify', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('type')->default(1)->comment('标签');
            $table->string('name','255')->default('')->comment('分类名称');
            $table->string('photo','255')->default('images/Koala.jpg')->comment('图像');
            $table->string('seo_title','255');
            $table->string('seo_keywords','255');
            $table->string('seo_desc','255');
            $table->unsignedTinyInteger('is_reveal')->default(0)->comment('是否首页展示');
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
        Schema::dropIfExists('classify');
    }
}
