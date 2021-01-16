<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'article',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('author_id')->default(0)->comment('作者ID');
                $table->string('classify_id')->default('')->comment('标签');
                $table->string('title', '255')->default('')->comment('文章标题');
                $table->longText('contont')->comment('文章内容');
                $table->string('photo', '400')->default('')->comment('图像');
                $table->string('file', '400')->default('')->comment('视频');
                $table->string('deleted_at', '100')->default('')->comment('删除');
                $table->unsignedTinyInteger('is_hot')->default(0)->comment('是否热点展示:0=否，1=是');
                $table->bigInteger('reading_volume')->default(0)->comment('阅读量');
                $table->unsignedTinyInteger('knowledge')->default(0)->comment('文章类型：1=问答，2=知识文章,3=话题');
                $table->text('seo_title');
                $table->text('seo_keywords');
                $table->text('seo_desc')->nullable();
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article');
    }
}
