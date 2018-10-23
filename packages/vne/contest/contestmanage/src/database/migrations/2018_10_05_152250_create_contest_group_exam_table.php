<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContestGroupExamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_cuocthi')->create('contest_group_exam', function (Blueprint $table) {
            $table->increments('group_exam_id');
            $table->string('name',200);
            $table->unsignedInteger('round_id');
            $table->text('description')->nullable();
            $table->text('list_candidate')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            $table->foreign('round_id')->references('round_id')->on('contest_round');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_cuocthi')->dropIfExists('contest_group_exam');
    }
}
