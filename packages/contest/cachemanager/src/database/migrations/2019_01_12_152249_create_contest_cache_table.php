<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContestCacheTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_cuocthi')->create('contest_cache', function (Blueprint $table) {
            $table->increments('cache_id');
            $table->string('cache_name',200);
            $table->string('cache_key',200);
            $table->text('cache_tags')->nullable();
            $table->text('cache_url');
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_cuocthi')->dropIfExists('contest_cache');
    }
}
