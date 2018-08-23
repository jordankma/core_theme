<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DhcdDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_dhcd')->create('dhcd_documents', function (Blueprint $table) {
            $table->increments('document_id');                        
            $table->integer('document_type_id')->unsigned();
            $table->foreign('document_type_id')->references('document_type_id')->on('dhcd_document_types');            
            $table->string('name');
            $table->string('alias');
            $table->longText('file')->nullable();            
            $table->longText('descript')->nullable();
            $table->string('icon')->nullable();
            $table->string('avatar')->nullable();
            $table->datetime('updated_file_at')->nullable();
            $table->tinyInteger('is_reserve', false, true)->comment('dai bieu moi')->default(0);
            $table->tinyInteger('is_offical', false, true)->comment('dai bieu chinh thuc')->default(0);
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
        Schema::connection('mysql_dhcd')->dropIfExists('dhcd_documents');
    }
}
