<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVneMember extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_cuocthi')->create('vne_member', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('sync_mongo', false, true)->comment('1 da sync mongo')->default(0);
            $table->tinyInteger('is_reg', false, true)->comment('0 chua nhap thong tin 1 da nhap')->default(0);
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
        Schema::connection('mysql_cuocthi')->dropIfExists('vne_member');
    }
}
