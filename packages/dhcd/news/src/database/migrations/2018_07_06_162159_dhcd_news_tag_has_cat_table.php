<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DhcdNewsTagHasCatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_dhcd')->create('dhcd_news_tag_has_cat', function (Blueprint $table) {
            $table->increments('news_tag_has_cat_id');
            $table->integer('news_cat_id', false, true)->index();
            $table->integer('news_tag_id', false, true)->index();
            $table->timestamps();
            $table->engine = 'InnoDB';
            $table->softDeletes();
            
            $table->foreign('news_cat_id')->references('news_cat_id')->on('dhcd_news_cat')->onDelete('cascade');
            $table->foreign('news_tag_id')->references('news_tag_id')->on('dhcd_news_tag')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::connection('mysql_dhcd')->dropIfExists('dhcd_news_tag_has_cat');
    }
}
