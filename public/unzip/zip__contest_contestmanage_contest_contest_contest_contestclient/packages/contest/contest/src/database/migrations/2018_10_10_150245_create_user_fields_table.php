<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_contest')->create('user_fields', function (Blueprint $table) {
            $table->increments('field_id');
            $table->string('label',200);
            $table->string('varible',200)->unique();
            $table->string('type_name',200);
            $table->string('type',200)->nullable();
            $table->string('hint_text',200)->nullable();
            $table->text('data_view')->nullable();
            $table->text('data_type')->nullable();
            $table->text('params_hidden')->nullable();
            $table->text('parent_field')->nullable();
            $table->text('description')->nullable();
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
        Schema::connection('mysql_contest')->dropIfExists('user_fields');
    }
}
