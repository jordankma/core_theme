<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDhcdHotel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_dhcd')->create('dhcd_hotel', function (Blueprint $table) {
            $table->increments('hotel_id');
            $table->string('doan_id');
            $table->string('hotel');
            $table->string('address');
            $table->string('img')->nullable();
            $table->text('hotel_staff')->nullable();
            $table->text('note')->nullable();

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
        Schema::connection('mysql_dhcd')->dropIfExists('dhcd_hotel');
    }
}
