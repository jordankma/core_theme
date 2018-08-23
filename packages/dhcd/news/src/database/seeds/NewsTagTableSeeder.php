<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class NewsTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dhcd_news_tag')->insert([
            'name'=>'Thể thao',
            'tag_alias'=>'the-thao',
            'status'=>1,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('dhcd_news_tag')->insert([
            'name'=>'Văn hóa',
            'tag_alias'=>'van-hoa',
            'status'=>1,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('dhcd_news_tag')->insert([
            'name'=>'Thế giới',
            'tag_alias'=>'the-gioi',
            'status'=>1,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('dhcd_news_tag')->insert([
            'name'=>'Công nghệ',
            'tag_alias'=>'cong-nghe',
            'status'=>1,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('dhcd_news_tag')->insert([
            'name'=>'Di động',
            'tag_alias'=>'di-dong',
            'status'=>1,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
    }
}
