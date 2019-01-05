<?php

namespace Contest\Contestmanage\App\Http\Controllers;

use Adtech\Application\Cms\Controllers\Controller as Controller;
use Contest\Contestmanage\App\ContestFunc;
use Contest\Contestmanage\App\Models\ContestResult;
use Contest\Contestmanage\App\Models\ContestResultJava;
use Contest\Contestmanage\App\Models\ContestRound;
use Contest\Contestmanage\App\Models\ContestTopic;
use Contest\Contestmanage\App\Models\Counters;
use Contest\Contestmanage\App\Models\RankBoard;
use Contest\Contestmanage\App\Models\UserContestInfo;
use Contest\Contestmanage\App\Repositories\ContestRoundRepository;
use Contest\Contestmanage\App\Repositories\ContestSeasonRepository;
use Contest\Contestmanage\App\Repositories\ContestTopicRepository;
use Contest\Contestmanage\App\Repositories\TopicRoundRepository;
use function foo\func;
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
        $member_cond = [];
        $result_cond = [];
        $name = null;

//        $cond['finish_exam'] = true;
        if (!empty($request->province_id) && $request->province_id != 0) {
            $member_cond['province_id'] = (int)$request->province_id;
        }
        if (!empty($request->district_id) && $request->district_id != 0) {
            $member_cond['district_id'] = (int)$request->district_id;
        }
        if (!empty($request->school_id) && $request->school_id != 0) {
            $member_cond['school_id'] = (int)$request->school_id;
        }
        if (!empty($request->table_id) && $request->table_id != 0) {
            $member_cond['table_id'] = (int)$request->table_id;
        }
        if (!empty($request->round_id) && $request->round_id != 0) {
            $result_cond['round_id'] = (int)$request->round_id;
        }
        if (!empty($request->topic_id) && $request->topic_id != 0) {
            $result_cond['topic_id'] = (int)$request->topic_id;
        }
        if (!empty($request->u_name)) {
            $member_cond['u_name'] = $request->u_name;
        }
        if (!empty($request->name)) {
            $name = $request->name;
        }

        $limit = !empty($request->limit) ? (int)$request->limit : 20;

        $result = ContestResult::with('candidate')->whereHas('candidate', function ($query) use($member_cond, $name){
            $query->where($member_cond);
            if(!empty($name)){
                $query->where('name','like','%'.$name.'%');
            }
        })->where($result_cond)->where('finish_time','!=',null)->orderBy('total_point', 'desc')->orderBy('used_time', 'asc')->paginate((int)$limit);

        $cond = array_merge($result_cond, $member_cond);

        if(!empty($cond)){
            $res = $result->withPath('http://timhieubiendao.daknong.vn/admin/api/contest/search_contest_result?'. http_build_query($cond));
        }
        else{
            $res = $result->withPath('http://timhieubiendao.daknong.vn/admin/api/contest/search_contest_result');
        }
        $res_data = json_decode($res->toJson());
        $headers = [];
        $table_data = RankBoard::where(['type' => 'search', 'params' => 'result'])->first();
        if(!empty($table_data)){
            foreach ($table_data->header as $key3 => $item3) {
                $headers[] = $item3['title'];
            }
            if(!empty($res_data->data)){
                $data_array = [];
                $idx = 1;
                foreach ($res_data->data as $key => $item) {
                    $data_array[$key] =[];
                    $data_array[$key][] = $idx++;
                    foreach ($table_data->header as $key3 => $item3) {

                        foreach ($item as $key2 => $item2) {

                            if ($item3['param'] == $key2) {
                                if($item3['param'] == 'used_time'){
                                    $data_array[$key][] = (new ContestFunc())->convertExamTime($item2);
                                }
                                else{
                                    $data_array[$key][] = $item2;
                                }

                            }
                        }
                        if (!empty($item->candidate)) {
                            foreach ($item->candidate as $key1 => $item1) {
                                if ($item3['param'] == $key1) {
                                    $data_array[$key][] = $item1;
                                }
                            }
                        }
                    }
                }
                $res_data->data = $data_array;
            }
            $res_data->headers = $headers;
            $res_data->title = $table_data->title;
            $res_data->success = true;
        }
        return response()->json($res_data);
    }

    public function getTopCandidate(Request $request)
    {
//        $test = ContestResult::with(['candidate' => function($q){
//            return $q->groupBy('district_id');
//        }])->get();
//        echo '<pre>';print_r($test);echo '</pre>';die;

        $top = !empty($request->top) ? (int)$request->top : 10;
        $page = !empty($request->page) ? (int)$request->page : 0;
        $skip = ($page != 0)?(($page - 1)*$top):0;
        $total_page = 0;
        $total_record = 0;
        $table = null;
        $data = null;
        $match = [];

        $aggregate = [];
        $aggregate[] = [
            '$lookup' => [
                'from' => "users_exam_info",
                'localField' => "member_id",
                'foreignField' => "member_id",
                'as' => "candidate"
            ]
        ];

        if (!empty($request->top_type)) {
            if ($request->top_type == 'province') {

                $aggregate[] = [
                    '$group' => [
                        "_id" => [
                            'name' => '$candidate.province_name',
                        ],
                        "uniqueCount" => ['$addToSet' => '$member_id'],
                    ]
                ];
            }
            elseif ($request->top_type == 'district') {
                $aggregate[] = [
                    '$group' => [
                        "_id" => [
                            'name' => '$candidate.district_name',
                        ],
                        "uniqueCount" => ['$addToSet' => '$member_id'],
                    ]
                ];
            }
            elseif ($request->top_type == 'school') {
                $aggregate[] = [
                    '$group' => [
                        "_id" => [
                            'name' => '$candidate.school_name',
                        ],
                        "uniqueCount" => ['$addToSet' => '$member_id'],
                    ]
                ];
            }
        }

        $aggregate[] = [
            '$unwind' => '$uniqueCount'
        ];
        $aggregate[] = [
            '$group' => [
                '_id' => '$_id.name',
                "total" => ['$sum' => 1]
            ]
        ];

        if (!empty($request->table_id)) {
            $match['table_id'] = (int)$request->table_id;
        }
        if (!empty($request->round_id)) {
            $match['round_id'] = (int)$request->round_id;
        }
        if (!empty($request->topic_id)) {
            $match['topic_id'] = (int)$request->topic_id;
        }
        if(!empty($match)){
            array_unshift($aggregate, ['$match' => $match]);
        }
        $aggregate[] = [
            '$sort' => ['total' => -1]
        ];
        $count_aggregate = $aggregate;
        $count_aggregate[] = [
            '$count' => 'total'
        ];
        $total_record = ContestResult::raw(function ($collection) use ( $top, $count_aggregate) {
            return $collection->aggregate($count_aggregate);
        });
        if(!empty($total_record[0])){
            $total_record = $total_record[0]->total;
        }
        else{
            $total_record = 0;
        }

        if (!empty($top) && $top != 'all' && $top != 0) {
            if(!empty($page) & $page != 0){
                $total_page = ceil($total_record / $top);
            }
            $aggregate[] = [
                '$limit' => $top + $skip + 2
            ];
        }
        if(!empty($skip) && $skip != 0){
            $aggregate[] = [
                '$skip' => $skip
            ];
        }

        $data = ContestResult::raw(function ($collection) use ($table, $top, $aggregate) {
            return $collection->aggregate($aggregate);
        });
        if(!empty($data)){
            $data_arr = [];
            $idx = 0;
            foreach ($data as $key => $value){
                if(!empty($value->_id[0])){
                    if($idx < ($top)){
                        $idx++;
                        $data_arr[$key] = [];
                        $data_arr[$key][] = $idx;
                        $data_arr[$key][] = $value->_id[0];
                        $data_arr[$key][] = $value->total;
                    }
                }
            }
            $data = $data_arr;
        }
        $res = [
            'success' => false,
            'messages' => null,
            'data' => null,
            'total_page' => null,
            'total_record' => null
        ];

        if($data != null){
            $res['success'] = true;
            $res['data'] = $data;
            $res['total_record'] = $total_record;
            $res['total_page'] = $total_page;
        }
        return response()->json($res);
    }

    public function getTopCandidate1(Request $request)
    {
//        $test = ContestResult::with(['candidate' => function($q){
//            return $q->groupBy('district_id');
//        }])->get();
//        echo '<pre>';print_r($test);echo '</pre>';die;

        $top = !empty($request->top) ? (int)$request->top : 10;
        $page = !empty($request->page) ? (int)$request->page : 0;
        $skip = ($page != 0)?(($page - 1)*$top):0;
        $total_page = 0;
        $total_record = 0;
        $table = null;
        $data = null;
        $match = [];

        $aggregate = [];
//        $aggregate[] = [
//            '$lookup' => [
//                'from' => "users_exam_info",
//                'localField' => "member_id",
//                'foreignField' => "member_id",
//                'as' => "candidate"
//            ]
//        ];

        if (!empty($request->top_type)) {
            if ($request->top_type == 'province') {

                $aggregate[] = [
                    '$group' => [
                        "_id" => [
                            'name' => '$candidate.province_name',
                        ],
                        "uniqueCount" => ['$addToSet' => '$member_id'],
                    ]
                ];
            }
            elseif ($request->top_type == 'district') {
                $aggregate[] = [
                    '$group' => [
                        "_id" => [
                            'name' => '$candidate.district_name',
                        ],
                        "uniqueCount" => ['$addToSet' => '$member_id'],
                    ]
                ];
            }
            elseif ($request->top_type == 'school') {
                $aggregate[] = [
                    '$group' => [
                        "_id" => [
                            'name' => '$candidate.school_name',
                        ],
                        "uniqueCount" => ['$addToSet' => '$member_id'],
                    ]
                ];
            }
        }

        $aggregate[] = [
            '$unwind' => '$uniqueCount'
        ];
        $aggregate[] = [
            '$group' => [
                '_id' => '$_id.name',
                "total" => ['$sum' => 1]
            ]
        ];

        if (!empty($request->table_id)) {
            $match['table_id'] = (int)$request->table_id;
        }
        if (!empty($request->round_id)) {
            $match['round_id'] = (int)$request->round_id;
        }
        if (!empty($request->topic_id)) {
            $match['topic_id'] = (int)$request->topic_id;
        }
        if(!empty($match)){
            array_unshift($aggregate, ['$match' => $match]);
        }
        $aggregate[] = [
            '$sort' => ['total' => -1]
        ];
        $count_aggregate = $aggregate;
        $count_aggregate[] = [
            '$count' => 'total'
        ];
        $total_record = ContestResult::raw(function ($collection) use ( $top, $count_aggregate) {
            return $collection->aggregate($count_aggregate);
        });
        if(!empty($total_record[0])){
            $total_record = $total_record[0]->total;
        }
        else{
            $total_record = 0;
        }

        if (!empty($top) && $top != 'all' && $top != 0) {
            if(!empty($page) & $page != 0){
                $total_page = ceil($total_record / $top);
            }
            $aggregate[] = [
                '$limit' => $top + $skip
            ];
        }
        if(!empty($skip) && $skip != 0){
            $aggregate[] = [
                '$skip' => $skip
            ];
        }

        $data = ContestResult::with('candidate')->raw(function ($collection) use ($table, $top, $aggregate) {
            return $collection->aggregate($aggregate);
        });
        echo '<pre>';print_r($data);echo '</pre>';die;
        if(!empty($data)){
            $data_arr = [];
            $idx = 0;
            foreach ($data as $key => $value){
                $idx++;
                $data_arr[$key] = [];
                if(!empty($value->_id[0])){
                    $data_arr[$key][] = $idx;
                    $data_arr[$key][] = $value->_id[0];
                    $data_arr[$key][] = $value->total;
                }
            }
            $data = $data_arr;
        }
        $res = [
            'success' => false,
            'messages' => null,
            'data' => null,
            'total_page' => null,
            'total_record' => null
        ];

        if($data != null){
            $res['success'] = true;
            $res['data'] = $data;
            $res['total_record'] = $total_record;
            $res['total_page'] = $total_page;
        }
        return response()->json($res);
    }

    public function getTopResult(Request $request)
    {
        $res = [
            'success' => false,
            'messages' => null,
            'data' => null,
            'total_page' => null,
            'total_record' => null
        ];
        $top = !empty($request->top) ? (int)$request->top : 10;
        $total_page = 0;
        $total_record = 0;
        $table = null;
        $data = null;
        $aggregate = [];

        $user_cond = [];
        $exam_cond = [];

        if (!empty($request->table_id)) {
            $user_cond['table_id'] = (int)$request->table_id;
        }
        if (!empty($request->province_id)) {
            $user_cond['province_id'] = (int)$request->province_id;
        }
        if (!empty($request->district_id)) {
            $user_cond['district_id'] = (int)$request->district_id;
        }
        if (!empty($request->school_id)) {
            $user_cond['school_id'] = (int)$request->school_id;
        }
        if (!empty($request->round_id)) {
            $exam_cond['round_id'] = (int)$request->round_id;
        }
        if (!empty($request->topic_id)) {
            $exam_cond['topic_id'] = (int)$request->topic_id;
        }
        if(!empty($exam_cond)){
            array_unshift($aggregate, ['$match' => $exam_cond]);
        }

        $result = ContestResult::with('candidate')->select(['member_id','round_id','topic_id','repeat_time','total_point','used_time'])->whereHas('candidate', function ($query) use($user_cond){
            $query->where($user_cond);
        })->where($exam_cond)->orderBy('total_point','desc')->orderBy('used_time', 'asc')->paginate($top);


        if(!empty($result)){
            $res_data = json_decode($result->toJson());
        }
        $table_data = RankBoard::where(['type' => 'top', 'params' => 'result'])->first();
        if(!empty($table_data)){
            foreach ($table_data->header as $key3 => $item3) {
                $headers[] = $item3['title'];
            }
            if(!empty($res_data->data)){
                $data_array = [];
                $idx = 1;
                foreach ($res_data->data as $key => $item) {
                    $data_array[$key] =[];
                    $data_array[$key][] = $idx++;
                    $candidate = UserContestInfo::where('member_id',(int)$item->member_id)->first();
                    foreach ($table_data->header as $key3 => $item3) {

                        foreach ($item as $key2 => $item2) {

                            if ($item3['param'] == $key2) {
                                if($item3['param'] == 'used_time'){
                                    $data_array[$key][] = (new ContestFunc())->convertExamTime($item2);
                                }
                                else{
                                    $data_array[$key][] = $item2;
                                }

                            }
                            else{
                                if(!empty($candidate)){
                                    foreach ($candidate as $key4 => $item4) {
                                        if($item3['param'] == $key4){
                                            $data_array[$key][] = $item4;
                                        }
                                    }
                                }
                            }
                        }
                        if (!empty($item->candidate)) {
                            foreach ($item->candidate as $key1 => $item1) {
                                if ($item3['param'] == $key1) {
                                    $data_array[$key][] = $item1;
                                }
                            }
                        }
                    }
                }
                $res_data->data = $data_array;
            }
            $res_data->headers = $headers;
            $res_data->title = $table_data->title;
            $res_data->success = true;
        }
        return response()->json($res_data);
    }

    public function getTopRegister(Request $request)
    {
        $res = [
            'success' => false,
            'messages' => null,
            'data' => null,
            'total_page' => null,
            'total_record' => null
        ];
        $top = !empty($request->top) ? (int)$request->top : 10;
        $page = !empty($request->page) ? (int)$request->page : 0;
        $skip = ($page != 0)?(($page - 1)*$top):0;
        $total_page = 0;
        $total_record = 0;
        $table = null;
        $data = null;
        $match = [];
        $aggregate = [];

        if (!empty($request->table_id)) {
            $match['table_id'] = (int)$request->table_id;
        }
        if (!empty($request->province_id)) {
            $match['province_id'] = (int)$request->province_id;
        }
        if (!empty($request->district_id)) {
            $match['district_id'] = (int)$request->district_id;
        }
        if (!empty($request->school_id)) {
            $match['school_id'] = (int)$request->school_id;
        }
        if(!empty($match)){
            array_unshift($aggregate, ['$match' => $match]);
        }
        if (!empty($request->top_type)) {
            if ($request->top_type == 'province') {
                $aggregate[] = [
                    '$group' => [
                        '_id' => '$province_id',
                        'name' => [
                            '$first' => '$province_name'
                        ],
                        'total' => ['$sum' => 1]
                    ]
                ];
            }
            elseif ($request->top_type == 'district') {
                $aggregate[] = [
                    '$group' => [
                        '_id' => '$district_id',
                        'name' => [
                            '$first' => '$district_name'
                        ],
                        'total' => ['$sum' => 1]
                    ]
                ];
            }
            elseif ($request->top_type == 'school') {
                $aggregate[] = [
                    '$group' => [
                        '_id' => '$school_id',
                        'name' => [
                            '$first' => '$school_name'
                        ],
                        'total' => ['$sum' => 1]
                    ]
                ];
            }
        }
        $aggregate[] = [
            '$sort' => ['total' => -1]
        ];
        $count_aggregate = $aggregate;
        $count_aggregate[] = [
            '$count' => 'total'
        ];
        $total_record = UserContestInfo::raw(function ($collection) use ( $top, $count_aggregate) {
            return $collection->aggregate($count_aggregate);
        });
        if(!empty($total_record[0])){
            $total_record = $total_record[0]->total;
        }
        else{
            $total_record = 0;
        }
        if (!empty($top) && $top != 'all' && $top != 0) {
            if(!empty($page) & $page != 0){
                $total_page = ceil($total_record / $top);
            }
            $aggregate[] = [
                '$limit' => $top + $skip
            ];
        }
        if(!empty($skip) && $skip != 0){
            $aggregate[] = [
                '$skip' => (int)$skip
            ];
        }
        $data = UserContestInfo::raw(function ($collection) use ($table, $top, $aggregate) {
            return $collection->aggregate($aggregate);
        });
        if(!empty($data)){
            $data_arr = [];
            $idx = 0;
            foreach ($data as $key => $value){
                $idx++;
                $data_arr[$key] = [];
                foreach ($value->getAttributes() as $key1 => $value1){
                    if($key1 == '_id'){
                        $data_arr[$key][] = $idx;
                    }
                    else{
                        $data_arr[$key][] = !empty($value1)?$value1:"";
                    }

                }
            }
            $data = $data_arr;
        }
        if($data != null){
            $res['success'] = true;
            $res['data'] = $data;
            $res['total_record'] = $total_record;
            $res['total_page'] = $total_page;
        }
        return response()->json($res);
    }

//    Đồng bộ db kết quả thi về contest_exam_result
    public function syncResult(Request $request)
    {
        $limit = !empty($request->limit) ? (int)$request->limit : 100;
        $offset = !empty($request->page) ? ((int)$request->page - 1) * 100 : 0;
//        $data = ContestResultJava::where('is_sync',false)->where('finish_time','!=',null)->skip(0)->take(500)->get();
        $query = ContestResultJava::where('is_sync','exists',false);
        $data = $query->orWhere(function($query)
        {
            $query->where('is_sync', false);
        })->where('finish_time','exists',true)->skip(0)->take(500)->get();

        if (!empty($data)) {
            $arr = [];
            $arr_ids = [];
            $count = Counters::find('contest_result_id');
            $last_id = $count->seq;
            foreach ($data as $key => $value) {
                $arr_ids[] = $value->_id;
                $last_id = $last_id + 1;
                $arr[$key] = [
                    '_id' => (int)$last_id
                ];
                foreach ($value->getAttributes() as $key1 => $value1) {
                    if($key1 != '_id' && $key1 != 'exam' && $key1 != 'answers'){
                        if($key1 == 'topic_id' || $key1 == 'round_id' || $key1 == 'contest_id' || $key1 == 'school_id'){
                            $arr[$key][$key1] = (int)$value1;
                        }
                        elseif($key1 == 'user_id'){
                            $arr[$key]['member_id'] = (int)$value1;
                        }
                        else{
                            $arr[$key][$key1] = $value1;
                        }
                    }

                }
            }
            $config_host = config('database.connections.mongodb.host');
            if(is_array($config_host)){
                $host = $config_host[0];
            }
            $port = config('database.connections.mongodb.port');
            $user = config('database.connections.mongodb.username');
            $pass = config('database.connections.mongodb.password');
            $db = config('database.connections.mongodb.database');
            try{
                $collection = (new Client('mongodb://'.$user.':'.$pass.'@'.$host.':'.$port.'/'.$db))->selectDatabase($db)->selectCollection('contest_exam_result');
//                $collection = (new Client('mongodb://'.$host.':'.$port.'/'.$db))->selectDatabase($db)->selectCollection('contest_exam_result');
                $mongo_result = $collection->insertMany($arr);
                if(!empty($mongo_result)){
                    $count->seq = (double)($last_id);
                    $count->update();
                    echo "<pre>";print_r($mongo_result->getInsertedIds());echo "</pre>";
//                    ContestResultJava::whereIn('user_id', $arr_ids)->update(['is_sync' => true]);
                    ContestResultJava::whereIn('_id',$arr_ids)->update(['is_sync' => true]);
                }
            }
            catch (\Exception $e){
                try{
                    if(is_array($config_host)){
                        $host = $config_host[1];
                        $collection = (new Client('mongodb://'.$user.':'.$pass.'@'.$host.':'.$port.'/'.$db))->selectDatabase($db)->selectCollection('contest_exam_result');
//                $collection = (new Client('mongodb://'.$host.':'.$port.'/'.$db))->selectDatabase($db)->selectCollection('contest_exam_result');
                        $mongo_result = $collection->insertMany($arr);
                        if(!empty($mongo_result)){
                            $count->seq = (double)($last_id);
                            $count->update();
                            echo "<pre>";print_r($mongo_result->getInsertedIds());echo "</pre>";
//                    ContestResultJava::whereIn('user_id', $arr_ids)->update(['is_sync' => true]);
                            ContestResultJava::whereIn('_id',$arr_ids)->update(['is_sync' => true]);
                        }
                    }
                }
                catch (\Exception $e){
                        echo "<pre>";print_r( $e->getMessage());echo "</pre>";
                    }
            }
        }
    }

//    Quản lý api + json BXH, TOP
    public function createRankBoard(){
        $type = [
            'top' => "TOP",
            'rank' => "BXH",
            'search' => "Tra cứu",
            'view' => "Kết quả thi"
        ];
        $data = [
            'type' => $type
        ];
        return view('CONTEST-CONTESTMANAGE::modules.contestmanage.rank_board.create', $data);
    }
    public function addRankBoard(Request $request){
        $rank = new RankBoard();
        $rank->title = $request->title;
        $rank->type = $request->type;
        $rank->params = $request->params;
        $data_child = [];
        if(!empty($request->data_child)){
            foreach (($request->data_child)['title'] as $key => $value){
                $data_child[$key] = new \stdClass();
                $data_child[$key]->title = $value;
                $data_child[$key]->params = $request->data_child['params'][$key];
                $data_child[$key]->limit = (int)$request->data_child['limit'][$key];
                $data_child[$key]->order = (int)$request->data_child['order'][$key];
                if(!empty(($request->data_child)['headers'][$key])){
                    $headers = explode(",",($request->data_child)['headers'][$key]);
                    $data_child[$key]->headers = $headers;
                }
            }

        }
        $rank->data_child = $data_child;
        $data_header = [];
        if(!empty($request->header)){
            foreach ($request->header['param'] as $key1 => $value1) {
                $data_header[] = [
                    'order' => $request->header['order'][$key1],
                    'param' => $request->header['param'][$key1],
                    'title' => $request->header['title'][$key1]
                ];
            }

        }
        $rank->header = $data_header;
        if ($rank->save()) {

//            activity('rank_board')
//                ->performedOn($rank)
//                ->withProperties($request->all())
//                ->log('User: :causer.email - Add cardProduct - name: :properties.name, product_id: ' . $tag->product_id);

            return redirect()->route('contest.contestmanage.rank_board.manage')->with('success', trans('card-contestmanage::language.messages.success.create'));
        } else {
            return redirect()->route('contest.contestmanage.rank_board.manage')->with('error', trans('card-contestmanage::language.messages.error.create'));
        }
    }
    public function manageRankBoard(){
        return view('CONTEST-CONTESTMANAGE::modules.contestmanage.rank_board.manage');
    }
    public function dataRankBoard(){
        return Datatables::of(RankBoard::all())
            ->addColumn('actions', function ($round) {
                $actions = '<a href=' . route('contest.contestmanage.contest_round.log', ['type' => 'contest_round', 'id' => $round->round_id]) . ' data-toggle="modal" data-target="#log"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="log contest_round"></i></a>
                       <a href=' . route('contest.contestmanage.contest_round.show', ['round_id' => $round->round_id]) . '><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="update contest_round"></i></a>
                <a href=' . route('contest.contestmanage.contest_round.confirm-delete', ['round_id' => $round->round_id]) . ' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete contest_round"></i></a>';

                return $actions;
            })
            ->rawColumns(['actions'])
            ->make();
    }

}