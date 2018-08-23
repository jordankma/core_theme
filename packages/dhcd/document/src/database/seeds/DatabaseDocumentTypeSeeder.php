<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseDocumentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dhcd_document_types')->insert([[
            'document_type_id' => 1,
            'name' => 'Hình ảnh',
            'type' => 'image',
            'extentions' => json_encode(['image/jpeg','image/jpg','image/png','image/gif','JPEG Image'])
        ],[
            'document_type_id' => 2,
            'name' => 'Văn bản',
            'type' => 'text',
            'extentions' => json_encode(['docx','doc','xls','xlsx','pdf','Microsoft Excel','Adobe Acrobat'])
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
}