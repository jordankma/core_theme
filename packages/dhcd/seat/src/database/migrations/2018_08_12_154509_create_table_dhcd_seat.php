<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDhcdSeat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::connection('mysql_dhcd')->create('dhcd_seat', function (Blueprint $table) {
            $table->increments('seat_id');
            $table->integer('doan_id');
            $table->integer('sessionseat_id');

            $table->string('seat');
            $table->text('seat_staff')->nullable();
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
        //
        Schema::connection('mysql_dhcd')->dropIfExists('dhcd_seat');
    }
}
