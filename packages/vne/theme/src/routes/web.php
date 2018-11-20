<?php
$adminPrefix = '';
Route::group(array('prefix' => $adminPrefix), function() {
    // Route::group(['middleware' => ['verify']], function () {

        //trang chu
        Route::get('/', 'HomeController@index')->name('index')->where('as','Frontend - Trang chủ');

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
        Route::get('top/{type?}', 'SearchController@getTop')->name('frontend.get.top');
        Route::get('top-dang-ky', 'SearchController@getTopRegister')->name('frontend.get.top.register');
        
        //trang thi
        Route::get('bai-thi', 'ExamController@listExam')->name('frontend.exam.list')->where('as','Frontend - Danh sách bài thi');
        Route::get('chi-tiet-bai-thi/{alias}.html', 'ExamController@detailExam')->name('frontend.news.contact')->where('as','Frontend - Bài thi chi tiết');
        Route::get('lich-thi', 'ExamController@scheduleExam')->name('frontend.exam.schedule')->where('as','Frontend - Lịch thi');

        // trang cap nhat thong tin
        Route::get('get-form-register', 'MemberController@getFormRegister')->name('frontend.member.get.form.register');
        Route::get('cap-nhat-thong-tin', 'MemberController@showRegisterMember')->name('frontend.member.register.show')->where('as','Frontend - Đăng ký member');
        Route::post('cap-nhat-thong-tin', 'MemberController@updateRegisterMember')->name('frontend.member.register.update');

    // });
    Route::group(['middleware' => ['verify.contest']], function () {
        Route::get('thi-thu', 'ContestController@getTryExam')->name('vne.get.try.exam');
        Route::get('thi-that', 'ContestController@getRealExam')->name('vne.get.real.exam');
    });
});