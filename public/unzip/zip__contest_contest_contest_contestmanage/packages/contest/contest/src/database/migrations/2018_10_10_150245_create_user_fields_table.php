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
        Schema::connection('mongodb')->create('user_fields', function (Blueprint $table) {
            $table->increments('feild_id');
            $table->string('label',200);
            $table->string('varible',200);
            $table->enum('input_type',200)->nullable();
            $table->text('value')->nullable();
            $table->string('api',200)->nullable();
            $table->boolean('is_require');
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
        Schema::connection('mongodb')->dropIfExists('user_fields');
    }
}
