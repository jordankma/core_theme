<?php
$adminPrefix = '';
Route::group(array('prefix' => $adminPrefix), function() {
    // Route::group(['middleware' => ['verify']], function () {

        //trang chu
        Route::get('/clear-cache', function(){
            Cache::tags(config('site.cache_tag'))->forget('list_time_line');
            Cache::tags(config('site.cache_tag'))->forget('count_thi_sinh_dang_ky');
            Cache::tags(config('site.cache_tag'))->forget('count_thi_sinh_thi');
            Cache::tags(config('site.cache_tag'))->forget('menus_frontend');
            Cache::tags(config('site.cache_tag'))->forget('banner_ngang_trang_chu_1');
            Cache::tags(config('site.cache_tag'))->forget('banner_ngang_trang_chu_2');
            Cache::tags(config('site.cache_tag'))->forget('banner_ngang_trang_chu_3');
            Cache::tags(config('site.cache_tag'))->forget('list_logo_ban_to_chuc_cuoc_thi');
            Cache::tags(config('site.cache_tag'))->forget('list_logo_don_vi_dong_hanh');
            Cache::tags(config('site.cache_tag'))->forget('menus_frontend');
        });
        Route::get('/', 'HomeController@index')->name('index')->where('as','Frontend - Trang chủ');
        Route::get('tin-tuc-box/{alias?}', 'HomeController@getNewByBox')->name('vne.index.news.box');
        //trang lien he
        Route::get('lien-he', 'ContactController@showContact')->name('frontend.contact.show')->where('as','Frontend - Liên hệ');
        Route::post('lien-he', 'ContactController@saveContact')->name('frontend.contact.save');
        
        //trang tin tuc
        Route::get('/tin-tuc/{alias?}', 'NewsController@listNews')->name('frontend.news.list')
        ->where('as','Frontend - Danh sách tin tức')
        ->where('type','news')
        ->where('view','list');
        Route::get('chi-tiet/{alias}.html', 'NewsController@detailNews')->name('frontend.news.details')
        ->where('as','Frontend - Tin tức chi tiết')
        ->where('type','news')
        ->where('view','detail');
        Route::get('vi-tri/{alias?}', 'NewsController@listNewsByBox')->name('frontend.news.list.box')
        ->where('as','Frontend - Danh sách tin tức theo vị trí')
        ->where('type','news')
        ->where('view','box');

        //cac trang search
        Route::get('danh-sach-thi-sinh', 'SearchController@listMember')->name('frontend.exam.list.member')->where('as','Frontend - Danh sách thí sinh');
        Route::get('ket-qua', 'SearchController@listResult')->name('frontend.exam.list.result')->where('as','Frontend - Danh sách kết quả thí sinh');
        Route::get('ket-qua-thi-sinh', 'SearchController@resultMember')->name('frontend.exam.result.member');
        Route::get('top/{type?}', 'SearchController@getTop')->name('frontend.get.top')->where('as','Frontend - Top thí sinh');
        Route::get('top-dang-ky', 'SearchController@getTopRegister')->name('frontend.get.top.register');
        
        //trang thi
        Route::get('bai-thi', 'ExamController@listExam')->name('frontend.exam.list')->where('as','Frontend - Danh sách bài thi');
        Route::get('chi-tiet-bai-thi/{alias}.html', 'ExamController@detailExam')->name('frontend.news.contact')->where('as','Frontend - Bài thi chi tiết');
        Route::get('lich-thi', 'ExamController@scheduleExam')->name('frontend.exam.schedule')->where('as','Frontend - Lịch thi');

        // trang cap nhat thong tin
        Route::get('get-form-register', 'MemberController@getFormRegister')->name('frontend.member.get.form.register');
        Route::get('get-form-register-2', 'MemberController@getFormRegister2')->name('frontend.member.get.form.register.2');
        Route::get('cap-nhat-thong-tin', 'MemberController@showRegisterMember')->name('frontend.member.register.show')->where('as','Frontend - Đăng ký member');
        Route::post('cap-nhat-thong-tin', 'MemberController@updateRegisterMember')->name('frontend.member.register.update');
        
    // });
    Route::group(['middleware' => ['verify.contest.hvltb.try']], function () {
        Route::get('thi-thu', 'ContestController@getTryExam')->name('vne.get.try.exam');
        
    });
    Route::group(['middleware' => ['verify.contest.hvltb.real']], function () {
        Route::get('thi-that', 'ContestController@getRealExam')->name('vne.get.real.exam');
    });
    
});