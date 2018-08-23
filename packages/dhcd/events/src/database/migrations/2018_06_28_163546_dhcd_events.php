<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DhcdEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::connection('mysql_dhcd')->create('dhcd_events', function (Blueprint $table) {
            $table->increments('event_id')->index();
            $table->string('name');
            $table->date('date');
            $table->longText('event_detail');
            $table->text('content');
            $table->tinyInteger('status')->default('1')->comment('0 la an 1 la hien');
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
        Schema::connection('mysql_dhcd')->dropIfExists('dhcd_events');
    }
}
