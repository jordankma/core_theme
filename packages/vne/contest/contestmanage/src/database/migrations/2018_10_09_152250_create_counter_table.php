<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCounterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mongodb')->create('counter', function (Blueprint $table) {

        });
        DB::connection('mongodb')->collection('counter')->insert(
            array(
                '_id' => 'candidate_id',
                'seq' => 0.0
            )
        );
        DB::connection('mongodb')->collection('counter')->insert(
            array(
                '_id' => 'group_exam_candidate_id',
                'seq' => 0.0
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mongodb')->dropIfExists('counter');
    }
}
