<?php
$adminPrefix = '';
Route::group(array('prefix' => $adminPrefix), function() {
    Route::post('login', 'AuthController@login')->name('vne.member.login');
    
    Route::get('set-session', 'AuthController@setSession')->name('vne.member.set.session');

    Route::post('register', 'AuthController@register')->name('vne.member.register');

    Route::get('logout', 'AuthController@logout')->name('vne.member.logout');
    
});