<?php
$adminPrefix = config('site.admin_prefix');
use Illuminate\Support\Facades\DB;
Route::group(array('prefix' => $adminPrefix), function() {
    Route::group(['middleware' => ['adtech.auth', 'adtech.acl']], function () {
        
        //tinh thanh pho
        Route::get('dhcd/administration/provine-city/log', 'ProvineCityController@log')->name('dhcd.administration.provine-city.log');
        Route::get('dhcd/administration/provine-city/data', 'ProvineCityController@data')->name('dhcd.administration.provine-city.data');
        Route::get('dhcd/administration/provine-city/manage', 'ProvineCityController@manage')->name('dhcd.administration.provine-city.manage')->where('as','Quản lý tỉnh thành');
        Route::get('dhcd/administration/provine-city/create', 'ProvineCityController@create')->name('dhcd.administration.provine-city.create');
        Route::post('dhcd/administration/provine-city/add', 'ProvineCityController@add')->name('dhcd.administration.provine-city.add');
        Route::get('dhcd/administration/provine-city/show', 'ProvineCityController@show')->name('dhcd.administration.provine-city.show');
        Route::post('dhcd/administration/provine-city/update', 'ProvineCityController@update')->name('dhcd.administration.provine-city.update');
        Route::get('dhcd/administration/provine-city/delete', 'ProvineCityController@delete')->name('dhcd.administration.provine-city.delete');
        Route::get('dhcd/administration/provine-city/confirm-delete', 'ProvineCityController@getModalDelete')->name('dhcd.administration.provine-city.confirm-delete');
        Route::post('dhcd/administration/provine-city/check-code', 'ProvineCityController@checkCode')->name('dhcd.administration.provine-city.check-code');


        // Route::get('dhcd/administration/country-district/member', 'CountryDistrictController@getCountryDistrict')->name('dhcd.administration.country-district.member');
    });
        Route::get('api/administration/provine-city-list', 'ProvineCityController@apiList');
});