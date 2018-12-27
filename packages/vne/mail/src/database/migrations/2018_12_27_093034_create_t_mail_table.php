<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTMailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_mail', function (Blueprint $table) {
            $table->increments('t_mail_id');
            $table->integer('sender_id');
            $table->integer('receiver_id');
            $table->integer('status');
            $table->string('receiver_name');
            $table->text('title');
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
        Schema::dropIfExists('t_mail');
    }
}
