<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advert', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedTinyInteger('advert_type')->default(1)->comment('广告类型');
            $table->string('code','300')->default('')->comment('广告代码');
            $table->unsignedTinyInteger('type')->default(1)->comment('广告位');
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
        Schema::dropIfExists('advert');
    }
}
