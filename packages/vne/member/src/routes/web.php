<?php
$adminPrefix = '';
Route::group(array('prefix' => $adminPrefix), function() {
    Route::post('login', 'MemberController@login')->name('vne.member.login');
    
    Route::post('register', 'MemberController@register')->name('vne.member.register');

    Route::get('logout', 'MemberController@logout')->name('vne.member.logout');
});