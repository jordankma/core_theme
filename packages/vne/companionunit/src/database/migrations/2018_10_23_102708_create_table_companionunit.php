<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCompanionunit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_cuocthi')->create('vne_comunit', function (Blueprint $table) {
            $table->increments('id');
            $table->string('comname');
            $table->tinyInteger('comtype')->comment('1 là đơn vị đồng hành, 0 là đơn vị tổ chức');
            $table->string('comlink')->nullable();
            $table->string('comnote')->nullable();
            $table->string('img');
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
        Schema::connection('mysql_cuocthi')->dropIfExists('vne_comunit');
    }
}
