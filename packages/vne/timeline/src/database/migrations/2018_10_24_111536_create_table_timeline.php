<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTimeline extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_cuocthi')->create('vne_timeline', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titles');
            $table->string('note')->nullable();
            $table->datetime('starttime')->format('m-d-Y H:i:s');
            $table->datetime('endtime')->format('m-d-Y H:i:s');
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
        Schema::connection('mysql_cuocthi')->dropIfExists('vne_timeline');
    }
}
