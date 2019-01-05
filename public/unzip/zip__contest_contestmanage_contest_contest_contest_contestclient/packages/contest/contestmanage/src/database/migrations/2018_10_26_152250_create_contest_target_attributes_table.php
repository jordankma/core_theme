<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContestTargetAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_cuocthi')->create('contest_target_attributes', function (Blueprint $table) {
            $table->increments('attribute_id');
            $table->string('label',200);
            $table->string('varible',200);
            $table->string('type_name',200);
            $table->string('hint_text',200);
            $table->text('data_view')->nullable();
            $table->string('api',200)->nullable();
            $table->unsignedInteger('type_id');
            $table->boolean('is_default');
            $table->boolean('is_require');
            $table->boolean('is_search');
            $table->boolean('show_on_info');
            $table->boolean('show_on_result');
            $table->tinyInteger('status');
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
        Schema::connection('mysql_cuocthi')->dropIfExists('contest_target_attributes');
    }
}
