<?php

namespace Contest\Contestmanage\App\Http\Controllers;

use Adtech\Application\Cms\Controllers\Controller as Controller;
use Contest\Contestmanage\App\Models\ContestResult;
use Contest\Contestmanage\App\Models\ContestResultJava;
use Contest\Contestmanage\App\Models\ContestRound;
use Contest\Contestmanage\App\Models\ContestTopic;
use Contest\Contestmanage\App\Models\Counters;
use Contest\Contestmanage\App\Models\UserContestInfo;
use Contest\Contestmanage\App\Repositories\ContestRoundRepository;
use Contest\Contestmanage\App\Repositories\ContestSeasonRepository;
use Contest\Contestmanage\App\Repositories\ContestTopicRepository;
use Contest\Contestmanage\App\Repositories\TopicRoundRepository;
use function GuzzleHttp\Psr7\build_query;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use MongoDB\Client;
use Validator;
use Yajra\Datatables\Datatables;

class ExamController extends Controller
{
    public function __construct(ContestSeasonRepository $seasonRepository, ContestRoundRepository $roundRepository, ContestTopicRepository $topicRepository, TopicRoundRepository $topicRoundRepository)
    {
        parent::__construct();
        $this->season = $seasonRepository;
        $this->round = $roundRepository;
        $this->topic = $topicRepository;
        $this->topic_round = $topicRoundRepository;
        $this->member_id = 0;
    }

    public function searchResult(Request $request)
    {
        $cond = [];
//        $cond['finish_exam'] = true;
        if (!empty($request->city_id) && $request->city_id != 0) {
            $cond['city_id'] = (int)$request->city_id;
        }
        if (!empty($request->district_id) && $request->district_id != 0) {
            $cond['district_id'] = (int)$request->district_id;
        }
        if (!empty($request->school_id) && $request->school_id != 0) {
            $cond['school_id'] = (int)$request->school_id;
        }
        if (!empty($request->table_id) && $request->table_id != 0) {
            $cond['table_id'] = (int)$request->table_id;
        }
        $limit = !empty($request->limit) ? $request->limit : 20;
        if (!empty($request->name)) {
//            $result = ContestResult::where($cond)->where('name','like','%'.$request->name.'%')->where('finish_time','!=',null)->orderBy('total_point', 'desc')->paginate($limit);
            $result = ContestResult::where($cond)->where('name','like','%'.$request->name.'%')->where('finish_time','!=',null)->where('is_reg','!=',null)->orderBy('point_real', 'desc')->paginate($limit);
        }
        else{
            $result = ContestResult::where($cond)->where('finish_time','!=',null)->where('is_reg','!=',null)->orderBy('point_real', 'desc')->paginate($limit);
        }
        return $result->withPath('http://timhieubiendao.daknong.vn/admin/api/contest/search_contest_result?'. http_build_query($request->all()));

    }

    public function getTop(Request $request)
    {
        $top = !empty($request->top) ? (int)$request->top : 10;
        if (!empty($request->top_type)) {
            if ($request->top_type == 'district') {
                if (!empty($request->table_id)) {
                    $table = (int)$request->table_id;
                    return ContestResult::raw(function ($collection) use($table)  {
                        return $collection->aggregate([
                            [
                                '$match' => [
                                    'table_id' => $table
                                ]
                            ],
                            [
                                '$group' => [
                                    "_id" => ['district_id' => '$district_id'],
                                    "uniqueCount" => ['$addToSet'=> '$user_id'],
                                ]
                            ],
                            [
                                '$unwind' => '$uniqueCount'
                            ],
                            [
                                '$group' => [
                                    "_id" => '$_id',
                                    "total" => ['$sum' => 1]
                                ]
                            ]

                        ]);
                    });
                } else {
                    return ContestResult::raw(function ($collection) {
                        return $collection->aggregate([
                            [
                                '$group' => [
                                    "_id" => ['district_id' => '$district_id'],
                                    "uniqueCount" => ['$addToSet'=> '$user_id'],
                                ]
                            ],
                            [
                                '$unwind' => '$uniqueCount'
                            ],
                            [
                                '$group' => [
                                    "_id" => '$_id',
                                    "total" => ['$sum' => 1]
                                ]
                            ]

                        ]);
                    });
                }
            }

        }
    }

    public function syncResult(Request $request)
    {
        $limit = !empty($request->limit) ? (int)$request->limit : 100;
        $offset = !empty($request->page) ? ((int)$request->page - 1) * 100 : 0;
        $data = ContestResultJava::where(['is_sync' => 2])->where('finish_time','!=',null)->skip($offset)->take($limit)->get();
        $current_topic = 1;
        if (!empty($data)) {
            $arr = [];
            $arr_ids = [];
            $count = Counters::find('contest_result_id');
            $last_id = $count->seq;
            foreach ($data as $key => $value) {
                $last_id += 1;
                $arr[$key] = [
                    '_id' => (int)$last_id
                ];
                foreach ($value->getAttributes() as $key1 => $value1) {
                    if($key1 != '_id'){
                        $arr[$key][$key1] = $value1;
                    }
                }
                if(!empty($value->answers)){
                    $point = 0;
                    $point_r1 = 5;
                    $point_r2 = 10;
                    foreach ($value->answers as $key3 => $value3) {
                        if ($value3['round_position'] == 1) {
                            if (!empty($value3['correct']) && $value3['correct'] == true) {
                                $point += $point_r1;
                            }
                        } elseif ($value3['round_position'] == 2) {
                            if (!empty($value3['correct']) && $value3['correct'] == true) {
                                $point += $point_r2;
                            }
                        }
                    }
                    $arr[$key]['point_real'] = (int)$point;
                }
                $mem_id = (int)$value->user_id;
                $user = UserContestInfo::where('member_id', $mem_id)->first();
                if (!empty($user)) {
                    foreach ($user->getAttributes() as $key2 => $attribute) {
                        if($key2 != '_id' && $key2 != 'member_id' && $key2 != 'password' && $key2 != 'sync_mongo' && $key2 != 'is_login'){
                            $arr[$key][$key2] = $attribute;
                        }
                    }
                }
                $arr_ids[] = strval($arr[$key]['user_id']);
            }
            try{
                $collection = (new Client('mongodb://123.30.174.148'))->selectDatabase('daknong')->selectCollection('contest_exam_result');
                $mongo_result = $collection->insertMany($arr);
                if(!empty($mongo_result)){
                    $count->seq = (double)($last_id);
                    $count->update();
                    echo "<pre>";print_r($mongo_result->getInsertedIds());echo "</pre>";
                    ContestResultJava::whereIn('user_id', $arr_ids)->update(['is_sync' => 1]);
                }
            }
            catch (\Exception $e){
                echo "<pre>";print_r( $e->getMessage());echo "</pre>";
            }
        }
    }

}