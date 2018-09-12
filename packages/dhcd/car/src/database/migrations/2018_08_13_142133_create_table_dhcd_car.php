<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDhcdCar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::connection('mysql_dhcd')->create('dhcd_car', function (Blueprint $table) {
            $table->increments('car_id');
            $table->string('doan_id')->nullable();
            $table->string('car_num');
            $table->string('car_bs')->nullable();
            $table->string('img')->nullable();
            $table->text('car_staff');
            $table->text('note')->comment('Lộ trình xe')->nullable();

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
        //
        Schema::connection('mysql_dhcd')->dropIfExists('dhcd_car');
    }
}
