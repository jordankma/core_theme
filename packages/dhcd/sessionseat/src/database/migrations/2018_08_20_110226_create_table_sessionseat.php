<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSessionseat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::connection('mysql_dhcd')->create('dhcd_sessionseat', function (Blueprint $table) {
            $table->increments('sessionseat_id');
            $table->string('sessionseat_name');
            $table->string('sessionseat_img');
            
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
        Schema::connection('mysql_dhcd')->dropIfExists('dhcd_sessionseat');
    }
}
