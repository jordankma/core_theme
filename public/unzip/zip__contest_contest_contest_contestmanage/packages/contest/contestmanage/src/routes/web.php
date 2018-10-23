<?php
$adminPrefix = config('site.admin_prefix');
Route::group(array('prefix' => $adminPrefix), function() {
    Route::group(['prefix' => 'api/contest', 'as' => 'api.contest.'], function () {
        Route::post('get_list_data', 'ApiController@getListData')->name('get_list_data');
        Route::get('data', 'ApiController@data')->name('data');
        Route::get('exam_info', 'ApiController@getExamInfo')->name('exam_info');
        Route::get('user_info', 'ApiController@getUserInfo')->name('user_info');
        Route::get('candidate_register', 'CandidateController@register')->name('candidate_register');
        Route::get('sync_candidate', 'CandidateController@syncRegister')->name('sync_candidate');
        Route::get('get_contest_result', 'ApiController@getContestResult')->name('get_contest_result');
        Route::get('search_contest_result', 'ExamController@searchResult')->name('search_contest_result');
        Route::get('sync_result', 'ExamController@syncResult')->name('sync_result');
        Route::get('get_top', 'ExamController@getTop')->name('get_top');
        Route::get('get_question_pack', 'ApiController@getQuestionPack')->name('get_question_pack');

    });
    Route::group(['middleware' => ['adtech.auth', 'adtech.acl']], function () {

//        Route::group(['prefix' => 'contest/contestmanage/contest', 'as' => 'contest.contestmanage.contest.'], function () {
//            Route::get('log', 'ContestController@log')->name('log');
//            Route::get('data', 'ContestController@data')->name('data');
//            Route::get('manage', 'ContestController@manage')->where('as','Danh sách cuộc thi')->name('manage');
//            Route::get('create', 'ContestController@create')->name('create');
//            Route::post('add', 'ContestController@add')->name('add');
//            Route::get('show', 'ContestController@show')->name('show');
//            Route::put('update', 'ContestController@update')->name('update');
//            Route::get('delete', 'ContestController@delete')->name('delete');
//            Route::get('confirm-delete', 'ContestController@getModalDelete')->name('confirm-delete');
//        });
        Route::group(['prefix' => 'contest/contestmanage/contest_season', 'as' => 'contest.contestmanage.contest_season.'], function () {
            Route::get('log', 'ContestSeasonController@log')->name('log');
            Route::get('data', 'ContestSeasonController@data')->name('data');
            Route::get('manage', 'ContestSeasonController@manage')->where('as','Danh sách mùa thi')->name('manage');
            Route::get('create', 'ContestSeasonController@create')->name('create');
            Route::get('change', 'ContestSeasonController@change')->name('change');
            Route::post('add', 'ContestSeasonController@add')->name('add');
            Route::post('get_config', 'ContestSeasonController@getConfig')->name('get_config');
            Route::get('show', 'ContestSeasonController@show')->name('show');
            Route::put('update', 'ContestSeasonController@update')->name('update');
            Route::get('delete', 'ContestSeasonController@delete')->name('delete');
            Route::get('confirm-delete', 'ContestSeasonController@getModalDelete')->name('confirm-delete');
        });
        Route::group(['prefix' => 'contest/contestmanage/contest_config', 'as' => 'contest.contestmanage.contest_config.'], function () {
            Route::get('log', 'ContestConfigController@log')->name('log');
            Route::get('data', 'ContestConfigController@data')->name('data');
            Route::post('list_data', 'ContestConfigController@listData')->name('list_data');
            Route::get('manage', 'ContestConfigController@manage')->where('as','Danh sách cấu hình')->name('manage');
            Route::get('create', 'ContestConfigController@create')->name('create');
            Route::post('add', 'ContestConfigController@add')->name('add');
            Route::post('view_detail', 'ContestConfigController@view')->name('view_detail');
            Route::post('list_target_id', 'ContestConfigController@listTargetId')->name('list_target_id');
            Route::get('show', 'ContestConfigController@show')->name('show');
            Route::put('update', 'ContestConfigController@update')->name('update');
            Route::get('delete', 'ContestConfigController@delete')->name('delete');
            Route::get('confirm-delete', 'ContestConfigController@getModalDelete')->name('confirm-delete');
        });
        Route::group(['prefix' => 'contest/contestmanage/contest_round', 'as' => 'contest.contestmanage.contest_round.'], function () {
            Route::get('log', 'ContestRoundController@log')->name('log');
            Route::get('data', 'ContestRoundController@data')->name('data');
            Route::get('manage', 'ContestRoundController@manage')->where('as','Danh sách vòng thi')->name('manage');
            Route::get('create', 'ContestRoundController@create')->name('create');
            Route::post('add', 'ContestRoundController@add')->name('add');
            Route::post('get_config', 'ContestRoundController@getConfig')->name('get_config');
            Route::get('show', 'ContestRoundController@show')->name('show');
            Route::put('update', 'ContestRoundController@update')->name('update');
            Route::get('delete', 'ContestRoundController@delete')->name('delete');
            Route::get('confirm-delete', 'ContestRoundController@getModalDelete')->name('confirm-delete');
        });
        Route::group(['prefix' => 'contest/contestmanage/contest_topic', 'as' => 'contest.contestmanage.contest_topic.'], function () {
            Route::get('log', 'ContestTopicController@log')->name('log');
            Route::get('data', 'ContestTopicController@data')->name('data');
            Route::post('get_list_question_pack', 'ContestTopicController@listQuestionPack')->name('get_list_question_pack');
            Route::post('get_question_pack_data', 'ContestTopicController@getQuestionPackData')->name('get_question_pack_data');
            Route::get('get_question_pack_data', 'ContestTopicController@getQuestionPackData')->name('get_question_pack_data');
            Route::get('manage', 'ContestTopicController@manage')->where('as','Danh sách màn thi')->name('manage');
            Route::get('create', 'ContestTopicController@create')->name('create');
            Route::post('add', 'ContestTopicController@add')->name('add');
            Route::get('show', 'ContestTopicController@show')->name('show');
            Route::put('update', 'ContestTopicController@update')->name('update');
            Route::get('delete', 'ContestTopicController@delete')->name('delete');
            Route::get('confirm-delete', 'ContestTopicController@getModalDelete')->name('confirm-delete');
        });
        Route::group(['prefix' => 'contest/contestmanage/topic_round', 'as' => 'contest.contestmanage.topic_round.'], function () {
            Route::get('log', 'TopicRoundController@log')->name('log');
            Route::get('data', 'TopicRoundController@data')->name('data');
            Route::get('manage', 'TopicRoundController@manage')->where('as','Danh sách vòng thi trong màn')->name('manage');
            Route::get('create', 'TopicRoundController@create')->name('create');
            Route::post('add', 'TopicRoundController@add')->name('add');
            Route::get('show', 'TopicRoundController@show')->name('show');
            Route::put('update', 'TopicRoundController@update')->name('update');
            Route::get('delete', 'TopicRoundController@delete')->name('delete');
            Route::get('confirm-delete', 'TopicRoundController@getModalDelete')->name('confirm-delete');
        });

        Route::group(['prefix' => 'contest/contestmanage/contest_client', 'as' => 'contest.contestmanage.contest_client.'], function () {
            Route::get('log', 'ContestClientController@log')->name('log');
            Route::get('data', 'ContestClientController@data')->name('data');
            Route::get('manage', 'ContestClientController@manage')->where('as','Danh sách client')->name('manage');
            Route::get('create', 'ContestClientController@create')->name('create');
            Route::post('add', 'ContestClientController@add')->name('add');
            Route::get('show', 'ContestClientController@show')->name('show');
            Route::put('update', 'ContestClientController@update')->name('update');
            Route::get('delete', 'ContestClientController@delete')->name('delete');
            Route::get('confirm-delete', 'ContestClientController@getModalDelete')->name('confirm-delete');
        });

        Route::group(['prefix' => 'contest/contestmanage/contest_tag', 'as' => 'contest.contestmanage.contest_tag.'], function () {
            Route::get('log', 'ContestTagController@log')->name('log');
            Route::get('data', 'ContestTagController@data')->name('data');
            Route::get('manage', 'ContestTagController@manage')->where('as','Danh sách tag')->name('manage');
            Route::get('create', 'ContestTagController@create')->name('create');
            Route::post('add', 'ContestTagController@add')->name('add');
            Route::get('show', 'ContestTagController@show')->name('show');
            Route::put('update', 'ContestTagController@update')->name('update');
            Route::get('delete', 'ContestTagController@delete')->name('delete');
            Route::get('confirm-delete', 'ContestTagController@getModalDelete')->name('confirm-delete');
        });

        Route::group(['prefix' => 'contest/contestmanage/group_exam', 'as' => 'contest.contestmanage.group_exam.'], function () {
            Route::get('log', 'GroupExamController@log')->name('log');
            Route::get('list_candidate', 'GroupExamController@listCandidate')->name('list_candidate');
            Route::post('list_candidate', 'GroupExamController@listCandidate')->name('list_candidate');
            Route::post('get_list_candidate', 'GroupExamController@getListCandidate')->name('get_list_candidate');
            Route::get('data_candidate', 'GroupExamController@dataCandidate')->name('data_candidate');
            Route::get('data', 'GroupExamController@data')->name('data');
            Route::get('manage', 'GroupExamController@manage')->where('as','Danh sách bảng thi')->name('manage');
            Route::get('create', 'GroupExamController@create')->name('create');
            Route::post('add', 'GroupExamController@add')->name('add');
            Route::post('add_candidate', 'GroupExamController@addCandidate')->name('add_candidate');
            Route::get('show', 'GroupExamController@show')->name('show');
            Route::put('update', 'GroupExamController@update')->name('update');
            Route::get('delete', 'GroupExamController@delete')->name('delete');
            Route::get('confirm-delete', 'GroupExamController@getModalDelete')->name('confirm-delete');
        });

        Route::group(['prefix' => 'contest/contestmanage/candidate', 'as' => 'contest.contestmanage.candidate.'], function () {
            Route::get('log', 'CandidateController@log')->name('log');
            Route::get('data', 'CandidateController@data')->name('data');
            Route::get('manage', 'CandidateController@manage')->where('as','Danh sách thí sinh')->name('manage');
            Route::get('create', 'CandidateController@create')->name('create');
            Route::post('add', 'CandidateController@add')->name('add');
            Route::get('get_list', 'CandidateController@getList')->name('get_list');
            Route::get('show', 'CandidateController@show')->name('show');
            Route::put('update', 'CandidateController@update')->name('update');
            Route::get('delete', 'CandidateController@delete')->name('delete');
            Route::get('confirm-delete', 'CandidateController@getModalDelete')->name('confirm-delete');
        });

        Route::group(['prefix' => 'contest/contestmanage/contest_target', 'as' => 'contest.contestmanage.contest_target.'], function () {
            Route::get('log', 'ContestTargetController@log')->name('log');
            Route::post('get_administrative', 'ContestTargetController@getAdministrativeData')->name('get_administrative');
            Route::get('show', 'ContestTargetController@show')->where('as','Quản lý đối tượng thi')->name('show');
            Route::put('update', 'ContestTargetController@update')->name('update');
        });
    });
});