<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DhcdDocumentCatesHasMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_dhcd')->create('dhcd_document_cate_has_member', function (Blueprint $table) {
            $table->increments('document_cate_has_member_id');
            $table->integer("document_cate_id",false,true);
            $table->integer("member_id",false,true);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('document_cate_id')->references('document_cate_id')->on('dhcd_document_cates');
            $table->foreign('member_id')->references('member_id')->on('dhcd_member');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_dhcd')->dropIfExists('dhcd_document_cates_has_member');
    }
}
