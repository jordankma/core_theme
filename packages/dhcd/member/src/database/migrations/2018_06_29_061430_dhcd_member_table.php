<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DhcdMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_dhcd')->create('dhcd_member', function (Blueprint $table) {
            $table->increments('member_id');
            $table->string('token')->nullable();
            $table->string('name');
            $table->integer('sort',false,true)->nullable();
            $table->string('u_name')->nullable();
            $table->string('password')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('phone')->unique()->nullable();
            $table->tinyInteger('type')->default('1')->comment('1 dai bieu chinh thuc 2 dai bieu moi');
            $table->string('bang_cap')->nullable();
            $table->string('ngay_vao_dang')->nullable();
            $table->string('ngay_vao_doan')->nullable();
            $table->string('dan_toc')->nullable();
            $table->integer('position_id',false,true)->default('0');
            $table->string('position_current',false,true)->nullable()->comment('tat ca chuc vu');
            $table->string('ton_giao')->nullable();
            $table->string('trinh_do_ly_luan')->nullable();
            $table->string('trinh_do_chuyen_mon')->nullable();
            $table->string('address')->nullable();
            
            $table->string('gender')->nullable();
            $table->string('avatar')->nullable();
            $table->string('don_vi')->nullable();
            $table->string('birthday')->nullable();
            $table->string('reg_ip')->nullable();
            $table->datetime('last_login')->nullable();
            $table->string('last_ip')->nullable();
            
            $table->tinyInteger('status', false, true)->comment('trang thai')->default(1);
            
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            // $table->foreign('position_id')->references('position_id')->on('dhcd_position')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_dhcd')->dropIfExists('dhcd_member');
    }
}
