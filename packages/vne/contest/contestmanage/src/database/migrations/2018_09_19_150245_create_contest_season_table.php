<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContestSeasonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_cuocthi')->create('contest_season', function (Blueprint $table) {
            $table->increments('season_id');
            $table->string('name',200);
            $table->string('alias',200);
            $table->string('db_info_name',200)->nullable();
            $table->string('db_result_name',200)->nullable();
            $table->unsignedInteger('number');
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->text('rule');
            $table->text('description')->nullable();
            $table->text('before_start_notify');
            $table->text('after_end_notify');
            $table->enum('status',['-1','0','1']);
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
        Schema::connection('mysql_cuocthi')->dropIfExists('contest_season');
    }
}
