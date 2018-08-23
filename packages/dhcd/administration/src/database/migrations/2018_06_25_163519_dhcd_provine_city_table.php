<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DhcdProvineCityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_dhcd')->create('dhcd_provine_city', function (Blueprint $table) {
            $table->increments('provine_city_id');
            $table->string('create_by')->comment('user_id cua nguoi dang tin');
            $table->string('name')->comment('name');
            $table->string('alias')->comment('alias');
            $table->string('type')->comment('kieu thanh pho hay tinh');
            $table->string('name_with_type')->comment('ten theo kieu')->nullable();
            $table->integer('code',false,true)->comment('ma tinh thanh pho');
            $table->tinyInteger('level', false, true)->comemt('cap')->default(1)->nullable();
            $table->tinyInteger('status', false, true)->comment('trang thai')->default(1);
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
        Schema::connection('mysql_dhcd')->dropIfExists('dhcd_provine_city');
    }
}
