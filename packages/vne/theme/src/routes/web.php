<?php
$adminPrefix = '';
Route::group(array('prefix' => $adminPrefix), function() {
    Route::group(['middleware' => ['verify']], function () {
        Route::get('/', 'HomeController@index')->name('index')->where('as','Frontend - Trang chủ');

        Route::get('lien-he', 'HomeController@showContact')->name('frontend.contact.show')->where('as','Frontend - Liên hệ');
        Route::post('lien-he', 'HomeController@saveContact')->name('frontend.contact.save');

        Route::get('/tin-tuc/{alias?}', 'HomeController@listNews')->name('frontend.news.list')
        ->where('as','Frontend - Danh sách tin tức')
        ->where('type','news')
        ->where('view','list');

        Route::get('chi-tiet/{alias}.html', 'HomeController@detailNews')->name('frontend.news.details')
        ->where('as','Frontend - Tin tức chi tiết')
        ->where('type','news')
        ->where('view','detail');

        Route::get('danh-sach-thi-sinh', 'HomeController@listMember')->name('frontend.exam.list.member')->where('as','Frontend - Danh sách thí sinh');
        Route::get('ket-qua', 'HomeController@listResult')->name('frontend.exam.list.result')->where('as','Frontend - Danh sách kết quả thí sinh');
        Route::get('/bai-thi', 'HomeController@listExam')->name('frontend.exam.list')->where('as','Frontend - Danh sách bài thi');

        Route::get('chi-tiet-bai-thi/{alias}.html', 'HomeController@detailExam')->name('frontend.news.contact')->where('as','Frontend - Bài thi chi tiết');

        Route::get('/lich-thi', 'HomeController@scheduleExam')->name('frontend.exam.schedule')->where('as','Frontend - Lịch thi');

        Route::get('get-form-register', 'HomeController@getFormRegister')->name('frontend.member.get.form.register');
        Route::get('cap-nhat-thong-tin', 'HomeController@showRegisterMember')->name('frontend.member.register.show')->where('as','Frontend - Đăng ký member');
        Route::post('/cap-nhat-thong-tin', 'HomeController@updateRegisterMember')->name('frontend.member.register.update');

        Route::get('get-token', 'HomeController@getToken');

        Route::get('get/district', 'HomeController@getDistrict')->name('vne.get.district');
        Route::get('get/school', 'HomeController@getSchool')->name('vne.get.school');
        Route::get('get/class', 'HomeController@getClass')->name('vne.get.class');
    });

    
});