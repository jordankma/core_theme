<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContestListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_contest')->create('contest_list', function (Blueprint $table) {
            $table->increments('contest_id');
            $table->string('name',200);
            $table->string('alias',200);
            $table->string('logo',200);
            $table->string('contest_tag',200);
            $table->string('url_static',200);
            $table->text('mysql_host',200);
            $table->text('mysql_port',200);
            $table->text('mysql_database',200);
            $table->text('mysql_username',200)->nullable();
            $table->text('mysql_password',200)->nullable();
            $table->text('mongodb_host',200);
            $table->text('mongodb_port',200);
            $table->text('mongodb_database',200);
            $table->text('mongodb_username',200)->nullable();
            $table->text('mongodb_password',200)->nullable();
            $table->unsignedInteger('domain_id');
            $table->text('domain_name');
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
        Schema::connection('mysql_contest')->dropIfExists('contest_list');
    }
}
