<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGMailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('g_mail', function (Blueprint $table) {
            $table->increments('g_mail_id');
            $table->integer('g_type');
            $table->integer('city_id');
            $table->integer('district_id');
            $table->integer('school_id');
            $table->integer('class_id');
            $table->integer('pclass_id');
            $table->integer('sender_id');
            $table->string('time');
            $table->string('title');
            $table->text('content');
            $table->text('attachment');

            $table->tinyInteger('status', false, true)->default(1);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('g_mail');
    }
}
