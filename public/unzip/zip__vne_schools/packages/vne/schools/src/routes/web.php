<?php
$adminPrefix = config('site.admin_prefix');
Route::group(array('prefix' => $adminPrefix), function () {
    Route::group(['middleware' => ['adtech.auth', 'adtech.acl']], function () {

        Route::get('vne/schools/log', 'SchoolsController@log')->name('vne.schools.log');
        Route::get('vne/schools/data', 'SchoolsController@data')->name('vne.schools.data');
        Route::get('vne/schools/manage', 'SchoolsController@manage')->where('as', 'Quản lý trường')->name('vne.schools.manage');
        Route::get('vne/schools/create', 'SchoolsController@create')->name('vne.schools.create');
        Route::post('vne/schools/add', 'SchoolsController@add')->name('vne.schools.add');
        Route::get('vne/schools/show', 'SchoolsController@show')->name('vne.schools.show');
        Route::put('vne/schools/update', 'SchoolsController@update')->name('vne.schools.update');
        Route::get('vne/schools/delete', 'SchoolsController@delete')->name('vne.schools.delete');
        Route::get('vne/schools/confirm-delete', 'SchoolsController@getModalDelete')->name('vne.schools.confirm-delete');

        Route::get('vne/schools/memdetail', 'SchoolsController@memdetail')->name('vne.schools.memdetail');
        Route::get('vne/schools/index', 'SchoolsController@index')->name('vne.schools.index');
        Route::post('vne/schools/getdistrict', 'SchoolsController@getdistrict')->name('vne.schools.getdistrict');
        Route::get('vne/schools/getlevel', 'SchoolsController@getlevel')->where('as', 'Quản lý khối')->name('vne.schools.getlevel');
        Route::post('vne/schools/addlevel', 'SchoolsController@addlevel')->name('vne.schools.addlevel');
        Route::post('vne/schools/getpunit', 'SchoolsController@getpunit')->name('vne.schools.getpunit');

        //route unit
        Route::get('vne/unit/log', 'UnitController@log')->name('vne.unit.log');
        Route::get('vne/unit/data', 'UnitController@data')->name('vne.unit.data');
        Route::get('vne/unit/manage', 'UnitController@manage')->where('as', 'Quản lý đơn vị tham gia')->name('vne.unit.manage');
        Route::get('vne/unit/create', 'UnitController@create')->name('vne.unit.create');
        Route::post('vne/unit/add', 'UnitController@add')->name('vne.unit.add');
        Route::get('vne/unit/show', 'UnitController@show')->name('vne.unit.show');
        Route::put('vne/unit/update', 'UnitController@update')->name('vne.unit.update');
        Route::get('vne/unit/delete', 'UnitController@delete')->name('vne.unit.delete');
        Route::get('vne/unit/confirm-delete', 'UnitController@getModalDelete')->name('vne.unit.confirm-delete');

        Route::get('vne/unit/memdetail', 'UnitController@memdetail')->name('vne.unit.memdetail');

        //route catunit
        Route::get('vne/catunit/create', 'CatuController@create')->name('vne.catunit.create');
        Route::post('vne/catunit/add', 'CatuController@add')->name('vne.catunit.add');
        Route::get('vne/catunit/manage', 'CatuController@manage')->where('as', 'Quản lý đơn vị đồng hành')->name('vne.catunit.manage');
        Route::get('vne/catunit/data', 'CatuController@data')->name('vne.catunit.data');
        Route::get('vne/catunit/show', 'CatuController@show')->name('vne.catunit.show');
        Route::get('vne/catunit/log', 'CatuController@log')->name('vne.catunit.log');
        Route::put('vne/catunit/update', 'CatuController@update')->name('vne.catunit.update');
        Route::get('vne/catunit/delete', 'CatuController@delete')->name('vne.catunit.delete');
        Route::get('vne/catunit/confirm-delete', 'CatuController@getModalDelete')->name('vne.catunit.confirm-delete');

        //route province
        Route::get('vne/schools/province/log', 'ProvinceController@log')->name('vne.schools.province.log');
        Route::get('vne/schools/province/data', 'ProvinceController@data')->name('vne.schools.province.data');
        Route::get('vne/schools/province/manage', 'ProvinceController@manage')->where('as', 'Quản lý tỉnh thành')->name('vne.schools.province.manage');
        Route::get('vne/schools/province/create', 'ProvinceController@create')->name('vne.schools.province.create');
        Route::post('vne/schools/province/add', 'ProvinceController@add')->name('vne.schools.province.add');
        Route::get('vne/schools/province/show', 'ProvinceController@show')->name('vne.schools.province.show');
        Route::put('vne/schools/province/update', 'ProvinceController@update')->name('vne.schools.province.update');
        Route::get('vne/schools/province/delete', 'ProvinceController@delete')->name('vne.schools.province.delete');
        Route::get('vne/schools/province/confirm-delete', 'ProvinceController@getModalDelete')->name('vne.schools.province.confirm-delete');

        //route district
        Route::get('vne/schools/district/log', 'DistrictController@log')->name('vne.schools.district.log');
        Route::get('vne/schools/district/data', 'DistrictController@data')->name('vne.schools.district.data');
        Route::get('vne/schools/district/manage', 'DistrictController@manage')->where('as', 'Quản lý quận huyện')->name('vne.schools.district.manage');
        Route::get('vne/schools/district/create', 'DistrictController@create')->name('vne.schools.district.create');
        Route::post('vne/schools/district/add', 'DistrictController@add')->name('vne.schools.district.add');
        Route::get('vne/schools/district/show', 'DistrictController@show')->name('vne.schools.district.show');
        Route::put('vne/schools/district/update', 'DistrictController@update')->name('vne.schools.district.update');
        Route::get('vne/schools/district/delete', 'DistrictController@delete')->name('vne.schools.district.delete');
        Route::get('vne/schools/district/confirm-delete', 'DistrictController@getModalDelete')->name('vne.schools.district.confirm-delete');

        //route nations
        Route::get('vne/nations/create', 'NationsController@create')->name('vne.nations.create');
        Route::post('vne/nations/add', 'NationsController@add')->name('vne.nations.add');
        Route::get('vne/nations/manage', 'NationsController@manage')->where('as', 'Quản lý đơn vị đồng hành')->name('vne.nations.manage');
        Route::get('vne/nations/data', 'NationsController@data')->name('vne.nations.data');
        Route::get('vne/nations/show', 'NationsController@show')->name('vne.nations.show');
        Route::get('vne/nations/log', 'NationsController@log')->name('vne.nations.log');
        Route::put('vne/nations/update', 'NationsController@update')->name('vne.nations.update');
        Route::get('vne/nations/delete', 'NationsController@delete')->name('vne.nations.delete');
        Route::get('vne/nations/confirm-delete', 'NationsController@getModalDelete')->name('vne.nations.confirm-delete');
    });
});
$apiPrefix = config('site.api_prefix');
Route::group(array('prefix' => $apiPrefix), function () {
//    Route::group(['middleware' => 'adtech.bearer'], function () {
        Route::get('vne/getprovince', 'ProvinceController@getprovince')->name('vne.getprovince');
        Route::get('vne/getdistrict/{_id}', 'DistrictController@getdistrict')->name('vne.getdistrict');
        Route::get('vne/getdistricts/{_id}', 'DistrictController@getdistricts')->name('vne.getdistricts');

//lấy trường theo quận huyên
        Route::get('vne/getschools/{_id}', 'SchoolsController@getschools')->name('vne.getschools');

//lấy trường theo id trường
        Route::get('vne/getschool/{_id}', 'SchoolsController@getschool')->name('vne.getschool');

//lấy đơn vị theo đơn vị cha
        Route::get('vne/getunitof', 'UnitController@getunitof')->name('vne.getunitof');

//lấy đơn vị theo quận huyện
        Route::get('vne/getunits', 'UnitController@getunits')->name('vne.getunits');

//lấy đơn vị theo Id
        Route::get('vne/getunit', 'UnitController@getunit')->name('vne.getunit');

//api lấy quốc gia
    Route::get('vne/getnations', 'NationsController@getnations')->name('vne.getnations');
//    });
});