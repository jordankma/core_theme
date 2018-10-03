<?php
$adminPrefix = '';
Route::group(array('prefix' => $adminPrefix), function() {
    Route::group(['middleware' => ['adtech.acl']], function () {
        Route::get('/', 'HomeController@index');

        Route::get('lien-he', 'HomeController@showContact')->name('frontend.contact.show')->where('as','Frontend - Liên hệ');
        Route::post('lien-he', 'HomeController@updateContact')->name('frontend.contact.update');

        Route::get('/tin-tuc/{alias?}', 'HomeController@listNews')->name('frontend.news.list')->where('as','Frontend - Danh sách tin tức');
        Route::get('/{alias}.html', 'HomeController@detailNews')->name('frontend.news.details')->where('as','Frontend - Tin tức chi tiết');

        Route::get('/bai-thi', 'HomeController@listExam')->name('frontend.exam.list')->where('as','Frontend - Danh sách bài thi');

        Route::get('chi-tiet-bai-thi/{alias}.html', 'HomeController@detailExam')->name('frontend.news.contact')->where('as','Frontend - Bài thi chi tiết');

        Route::get('/lich-thi', 'HomeController@scheduleExam')->name('frontend.exam.schedule')->where('as','Frontend - Lịch thi');

        Route::get('/dang-ky', 'HomeController@showRegisterMember')->name('frontend.member.register.show')->where('as','Frontend - Đăng ký member');
        Route::post('/dang-ky', 'HomeController@updateRegisterMember')->name('frontend.member.register.update');


    });
});