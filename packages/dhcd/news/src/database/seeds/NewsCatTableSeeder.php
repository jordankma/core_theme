<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class NewsCatTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dhcd_news_cat')->insert([
            'name'=>'Thể thao',
            'parent_news_cat_id'=>0,
            'cat_alias'=>'the-thao',
            'status'=>1,
            'visible'=>1,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('dhcd_news_cat')->insert([
            'name'=>'Văn hóa',
            'parent_news_cat_id'=>0,
            'cat_alias'=>'van-hoa',
            'status'=>1,
            'visible'=>1,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
    }
}
