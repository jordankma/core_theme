<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContestTopicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_cuocthi')->create('contest_topic', function (Blueprint $table) {
            $table->increments('topic_id');
            $table->string('display_name',200);
            $table->string('topic_name',200);
            $table->enum('type',['online','offline']);
            $table->enum('topic_type',['test','real']);
            $table->text('description')->nullable();
            $table->text('rule_text')->nullable();
            $table->text('topic_round');
            $table->unsignedInteger('order');
            $table->unsignedInteger('round_id');
            $table->unsignedInteger('question_pack_id');
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->integer('exam_repeat_time');
            $table->unsignedInteger('exam_repeat_time_wait');
            $table->unsignedInteger('total_time_limit');
            $table->text('end_notify')->nullable();
            $table->enum('status',['-1','0','1']);
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
        Schema::connection('mysql_cuocthi')->dropIfExists('contest_topic');
    }
}
