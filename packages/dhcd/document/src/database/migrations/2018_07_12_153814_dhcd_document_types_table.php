<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DhcdDocumentTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_dhcd')->create('dhcd_document_types', function (Blueprint $table) {
            $table->increments('document_type_id');            
            $table->string('name');
            $table->string('type');
            $table->string('extentions')->nullable();                       
            $table->timestamps();
            $table->softDeletes();
        });
        
        DB::connection('mysql_dhcd')->table('dhcd_document_types')->insert([[
            'document_type_id' => 1,
            'name' => 'Hình ảnh',
            'type' => 'image',
            'extentions' => json_encode(['image/jpeg','image/jpg','image/png','image/gif'])
        ],[
            'document_type_id' => 2,
            'name' => 'Văn bản',
            'type' => 'text',
            'extentions' => json_encode(['docx','doc','xls','xlsx','pdf'])
        ],[
            'document_type_id' => 3,
            'name' => 'Video',
            'type' => 'video',
            'extentions' => json_encode(['mp4'])
        ],[
            'document_type_id' => 4,
            'name' => 'Audio',
            'type' => 'audio',
            'extentions' => json_encode(['mp3'])
        ]]);
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_dhcd')->dropIfExists('dhcd_document_types');
    }
}
