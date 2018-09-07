<?php
$adminPrefix = config('site.admin_prefix');

/**
 * Frontend Routes
 */
Route::group(array('prefix' => null), function () {
    Route::match(['get', 'post'], 'login', 'Auth\LoginController@login')->name('dhcd.member.auth.login');

    Route::group(['middleware' => ['dhcd.auth']], function () {
        // Route::get('', '\Adtech\Core\App\Http\Controllers\FrontendController@index')->name('frontend.homepage');

        Route::get('logout', 'Auth\LoginController@logout')->name('dhcd.member.auth.logout')->where('as','Đăng xuất');
    });
});

Route::group(array('prefix' => $adminPrefix), function() {
    Route::group(['middleware' => ['adtech.auth', 'adtech.acl']], function () {
        //member
        Route::get('dhcd/member/member/log', 'MemberController@log')->name('dhcd.member.member.log');
        Route::get('dhcd/member/member/data', 'MemberController@data')->name('dhcd.member.member.data');
        Route::get('dhcd/member/member/manage', 'MemberController@manage')->name('dhcd.member.member.manage')->where('as','Người dùng - danh sách');
        Route::get('dhcd/member/member/create', 'MemberController@create')->name('dhcd.member.member.create');
        Route::post('dhcd/member/member/add', 'MemberController@add')->name('dhcd.member.member.add');
        Route::get('dhcd/member/member/show', 'MemberController@show')->name('dhcd.member.member.show');
        Route::post('dhcd/member/member/update', 'MemberController@update')->name('dhcd.member.member.update');
        Route::get('dhcd/member/member/delete', 'MemberController@delete')->name('dhcd.member.member.delete');
        Route::get('dhcd/member/member/confirm-delete', 'MemberController@getModalDelete')->name('dhcd.member.member.confirm-delete');
        Route::get('dhcd/member/member/block', 'MemberController@block')->name('dhcd.member.member.block');
        Route::get('dhcd/member/member/confirm-block', 'MemberController@getModalBlock')->name('dhcd.member.member.confirm-block');

        Route::post('dhcd/member/member/check-email-exist', 'MemberController@checkEmailExist')->name('dhcd.member.member.check-email-exist');
        Route::post('dhcd/member/member/check-phone-exist', 'MemberController@checkPhoneExist')->name('dhcd.member.member.check-phone-exist');

        Route::get('dhcd/member/member/sync/{type}','MemberController@sync');
        //import export member excel
        Route::get('dhcd/member/member/excel/get/import', 'MemberController@getImport')->name('dhcd.member.member.excel.get.import')->where('as','Upload excel');
        Route::post('dhcd/member/member/excel/post/import', 'MemberController@postImport')->name('dhcd.member.member.excel.post.import');
        //group member 
        
        Route::get('dhcd/member/group/sync/{type}','GroupController@sync');
        
        Route::get('dhcd/member/group/log', 'GroupController@log')->name('dhcd.member.group.log');
        Route::get('dhcd/member/group/data', 'GroupController@data')->name('dhcd.member.group.data');
        Route::get('dhcd/member/group/manage', 'GroupController@manage')->name('dhcd.member.group.manage')->where('as','Nhóm người dùng - Danh sách');
        Route::get('dhcd/member/group/create', 'GroupController@create')->name('dhcd.member.group.create');
        Route::post('dhcd/member/group/add', 'GroupController@add')->name('dhcd.member.group.add');
        Route::get('dhcd/member/group/show', 'GroupController@show')->name('dhcd.member.group.show');
        Route::post('dhcd/member/group/update', 'GroupController@update')->name('dhcd.member.group.update');
        Route::get('dhcd/member/group/delete', 'GroupController@delete')->name('dhcd.member.group.delete');
        Route::get('dhcd/member/group/confirm-delete', 'GroupController@getModalDelete')->name('dhcd.member.group.confirm-delete');

        //add member to group
        Route::get('dhcd/member/group/manage/add/member', 'GroupController@manageAddGroup')->name('dhcd.member.group.manage.add.member');
        Route::post('dhcd/member/group/add/member', 'GroupController@addMember')->name('dhcd.member.group.add.member');
        Route::get('dhcd/member/group/data/member', 'GroupController@dataMember')->name('dhcd.member.group.data.member');
        Route::get('dhcd/member/group/delete/member', 'GroupController@deleteMember')->name('dhcd.member.group.delete.member');
        Route::get('dhcd/member/group/confirm-delete/member', 'GroupController@getModalDeleteMember')->name('dhcd.member.group.confirm-delete.member');
        Route::get('dhcd/member/group/search/member', 'GroupController@searchMember')->name('dhcd.member.group.search.member');

        Route::get('dhcd/member/group/test', 'GroupController@test');

        //position
        Route::get('dhcd/member/position/log', 'PositionMemberController@log')->name('dhcd.member.position.log');
        Route::get('dhcd/member/position/data', 'PositionMemberController@data')->name('dhcd.member.position.data');
        Route::get('dhcd/member/position/manage', 'PositionMemberController@manage')->name('dhcd.member.position.manage')->where('as','Chức vụ - Danh sách');
        Route::get('dhcd/member/position/create', 'PositionMemberController@create')->name('dhcd.member.position.create');
        Route::post('dhcd/member/position/add', 'PositionMemberController@add')->name('dhcd.member.position.add');
        Route::get('dhcd/member/position/show', 'PositionMemberController@show')->name('dhcd.member.position.show');
        Route::post('dhcd/member/position/update', 'PositionMemberController@update')->name('dhcd.member.position.update');
        Route::get('dhcd/member/position/delete', 'PositionMemberController@delete')->name('dhcd.member.position.delete');
        Route::get('dhcd/member/position/confirm-delete', 'PositionMemberController@getModalDelete')->name('dhcd.member.position.confirm-delete');
    });
    Route::get('api/member/group-list', 'GroupController@apiList');

});

Route::group(array('prefix' => 'resource/dev'), function() {
    Route::post('post/login', 'ApiMemberController@postLogin');
    Route::get('get/register', 'ApiMemberController@getRegister');
    Route::get('get/getuserinfo', 'ApiMemberController@getUserInfo');
    Route::put('put/user/change-password', 'ApiMemberController@putChangePass');

    Route::get('get/list/group', 'ApiMemberController@getListGroup');
    Route::get('get/list/member/group', 'ApiMemberController@getListMemberGroup');
});
