<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class NewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dhcd_news')->insert([
            'user_id' => 1,
            'news_cat' => '[{"news_cat_id":1,"name":"thethao"},{"news_cat_id":2,"name":"the gioi"}]',
            'news_tag' => '[{"tag_id":1,"name":"thethao"},{"tag_id":2,"name":"the gioi"}]',
            'title' => 'Bài viết đầu tiên',
            'title_alias'=>'bai-viet-dau-tien',
            'desc'=>'Mô tả',
            'content'=>'Nội dung',
            'image'=>'tuan.com/anh1.png',
            'is_hot'=>'1',
            'priority'=>'1',
            'status'=>'1',
            'key_word_seo'=>'[key1,key2]',
            'desc_seo'=>'Mô tả seo',
            'visible'=>'1',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('dhcd_news')->insert([
            'user_id' => 1,
            'news_cat' => '[{"news_cat_id":1,"name":"thethao"},{"news_cat_id":2,"name":"the gioi"}]',
            'news_tag' => '[{"tag_id":1,"name":"thethao"},{"tag_id":2,"name":"the gioi"}]',
            'title' => 'Bài viết đầu tiên 2',
            'title_alias'=>'bai-viet-dau-tien-2',
            'desc'=>'Mô tả',
            'content'=>'Nội dung',
            'image'=>'tuan.com/anh1.png',
            'is_hot'=>'1',
            'priority'=>'1',
            'status'=>'1',
            'key_word_seo'=>'[key1,key2]',
            'desc_seo'=>'Mô tả seo',
            'visible'=>'1',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('dhcd_news')->insert([
            'user_id' => 1,
            'news_cat' => '[{"news_cat_id":1,"name":"thethao"},{"news_cat_id":2,"name":"the gioi"}]',
            'news_tag' => '[{"tag_id":1,"name":"thethao"},{"tag_id":2,"name":"the gioi"}]',
            'title' => 'Bài viết đầu tiên 3',
            'title_alias'=>'bai-viet-dau-tien-3',
            'desc'=>'Mô tả',
            'content'=>'Nội dung',
            'image'=>'tuan.com/anh1.png',
            'is_hot'=>'1',
            'priority'=>'1',
            'status'=>'1',
            'key_word_seo'=>'[key1,key2]',
            'desc_seo'=>'Mô tả seo',
            'visible'=>'1',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('dhcd_news')->insert([
            'user_id' => 1,
            'news_cat' => '[{"news_cat_id":1,"name":"thethao"},{"news_cat_id":2,"name":"the gioi"}]',
            'news_tag' => '[{"tag_id":1,"name":"thethao"},{"tag_id":2,"name":"the gioi"}]',
            'title' => 'Bài viết đầu tiên 4',
            'title_alias'=>'bai-viet-dau-tien-4',
            'desc'=>'Mô tả',
            'content'=>'Nội dung',
            'image'=>'tuan.com/anh1.png',
            'is_hot'=>'1',
            'priority'=>'1',
            'status'=>'1',
            'key_word_seo'=>'[key1,key2]',
            'desc_seo'=>'Mô tả seo',
            'visible'=>'1',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('dhcd_news')->insert([
            'user_id' => 1,
            'news_cat' => '[{"news_cat_id":1,"name":"thethao"},{"news_cat_id":2,"name":"the gioi"}]',
            'news_tag' => '[{"tag_id":1,"name":"thethao"},{"tag_id":2,"name":"the gioi"}]',
            'title' => 'Bài viết đầu tiên 5',
            'title_alias'=>'bai-viet-dau-tien-5',
            'desc'=>'Mô tả',
            'content'=>'Nội dung',
            'image'=>'tuan.com/anh1.png',
            'is_hot'=>'1',
            'priority'=>'1',
            'status'=>'1',
            'key_word_seo'=>'[key1,key2]',
            'desc_seo'=>'Mô tả seo',
            'visible'=>'1',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('dhcd_news')->insert([
            'user_id' => 1,
            'news_cat' => '[{"news_cat_id":1,"name":"thethao"},{"news_cat_id":2,"name":"the gioi"}]',
            'news_tag' => '[{"tag_id":1,"name":"thethao"},{"tag_id":2,"name":"the gioi"}]',
            'title' => 'Bài viết đầu tiên 6',
            'title_alias'=>'bai-viet-dau-tien-6',
            'desc'=>'Mô tả',
            'content'=>'Nội dung',
            'image'=>'tuan.com/anh1.png',
            'is_hot'=>'1',
            'priority'=>'1',
            'status'=>'1',
            'key_word_seo'=>'[key1,key2]',
            'desc_seo'=>'Mô tả seo',
            'visible'=>'1',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('dhcd_news')->insert([
            'user_id' => 1,
            'news_cat' => '[{"news_cat_id":1,"name":"thethao"},{"news_cat_id":2,"name":"the gioi"}]',
            'news_tag' => '[{"tag_id":1,"name":"thethao"},{"tag_id":2,"name":"the gioi"}]',
            'title' => 'Bài viết đầu tiên 7',
            'title_alias'=>'bai-viet-dau-tien-7',
            'desc'=>'Mô tả',
            'content'=>'Nội dung',
            'image'=>'tuan.com/anh1.png',
            'is_hot'=>'1',
            'priority'=>'1',
            'status'=>'1',
            'key_word_seo'=>'[key1,key2]',
            'desc_seo'=>'Mô tả seo',
            'visible'=>'1',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
    }
}
