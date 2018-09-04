<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DhcdLogSentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dhcd_log_sent', function (Blueprint $table) {
            $table->increments('log_sent_id');
            $table->integer("notification_id", false, true)->comment('id thong bao gui');
            $table->string("create_by")->comment('id nguoi gui thong bao gui');

            $table->integer("member_sent", false, true)->comment('id nguoi gui truong hop sent 1 nguoi')->nullable();
            $table->datetime("time_sent")->comment('thời gian gửi')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('notification_id')->references('notification_id')->on('dhcd_notification')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dhcd_log_sent');
    }
}
