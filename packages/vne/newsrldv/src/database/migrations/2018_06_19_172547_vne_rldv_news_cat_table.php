<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VneRldvNewsCatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_cuocthi')->create('vne_rldv_news_cat', function (Blueprint $table) {
            $table->increments('news_cat_id');
            $table->integer('parent')->comment('id cua chuyen muc cha');
            $table->string('name');
            $table->string('alias');
            $table->tinyInteger('status')->comment('1 duyet 0 cho duyet')->default(1); 
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_cuocthi')->dropIfExists('vne_rldv_news_cat');
    }
}
