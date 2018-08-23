<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdtechCoreRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_core')->create('adtech_core_roles', function (Blueprint $table) {
            $table->increments('role_id')->index();
            $table->string('name');
            $table->tinyInteger('permission_locked', false, true)->default(0);
            $table->tinyInteger('sort', false, true)->default(99);
            $table->tinyInteger('status', false, true)->default(1);

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
        Schema::connection('mysql_core')->dropIfExists('adtech_core_roles');
    }
}
