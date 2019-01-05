<?php

namespace Contest\Contestmanage\App\Http\Controllers;

use Adtech\Application\Cms\Controllers\Controller as Controller;
use Contest\Contestmanage\App\ContestFunc;
use Contest\Contestmanage\App\Models\ContestResult;
use Contest\Contestmanage\App\Models\ContestResultJava;
use Contest\Contestmanage\App\Models\ContestRound;
use Contest\Contestmanage\App\Models\ContestSetting;
use Contest\Contestmanage\App\Models\ContestTarget;
use Contest\Contestmanage\App\Models\ContestTopic;
use Contest\Contestmanage\App\Models\FormLoad;
use Contest\Contestmanage\App\Models\RankBoard;
use Contest\Contestmanage\App\Models\UserContestInfo;
use Contest\Contestmanage\App\Repositories\ContestRoundRepository;
use Contest\Contestmanage\App\Repositories\ContestSeasonRepository;
use Contest\Contestmanage\App\Repositories\ContestTopicRepository;
use Contest\Contestmanage\App\Repositories\TopicRoundRepository;
use GuzzleHttp\Client;
use function GuzzleHttp\Promise\promise_for;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Tebru\Gson\Gson;
use Validator;
use Yajra\Datatables\Datatables;

class ApiController extends Controller
{
    public function __construct(ContestSeasonRepository $seasonRepository, ContestRoundRepository $roundRepository, ContestTopicRepository $topicRepository, TopicRoundRepository $topicRoundRepository)
    {
        parent::__construct();
        $this->season = $seasonRepository;
        $this->round = $roundRepository;
        $this->topic = $topicRepository;
        $this->topic_round = $topicRoundRepository;
    }

    public function getListData(Request $request)
    {
        $data_view = [
            'type' => $request->type,
            'title' => ''
        ];
        $html = view('CONTEST-CONTESTMANAGE::modules.contestmanage.includes.get_list_data', $data_view)->render();
        return response()->json($html);
    }

//Table Data to index page
    public function data(Request $request)
    {
//        echo '<pre>';print_r($this->my_simple_crypt('bUJSVzA1K1dvM1VXSVJHYUE3K0paRnpjdFdqY2FuSEJZK2N5L2JtOW5Taz0=','d'));echo '</pre>';die;
//        echo '<pre>';print_r($this->my_simple_crypt('bUJSVzA1K1dvM1VXSVJHYUE3K0paRnpjdFdqY2FuSEJZK2N5L2JtOW5Taz0=','d'));echo '</pre>';die;
        if (!empty($request->type)) {
            switch ($request->type) {
                case 'season':
                    return Datatables::of($this->season->findAll())
                        ->addColumn('actions', function ($season) {
                            $actions = '<a href="javascript:void(0)" c-data="' . $season->name . '" data-value="' . $season->season_id . '" class="season_choose"><i class="livicon" data-name="plus" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="chọn"></i></a>';
                            return $actions;
                        })
                        ->rawColumns(['actions'])
                        ->make();
                    break;
                case 'round':
                    return Datatables::of($this->round->findAll())
                        ->editColumn('display_name', function ($round){
                            if(!empty($round->display_name)){
                                return base64_decode($round->display_name);
                            }
                            else{
                                return '';
                            }
                        })
                        ->editColumn('description', function ($round){
                            if(!empty($round->description)){
                                return base64_decode($round->description);
                            }
                            else{
                                return '';
                            }
                        })
                        ->addColumn('actions', function ($round) {
                            $actions = '<a href="javascript:void(0)" c-data="' . $round->display_name . '" data-value="' . $round->round_id . '" class="round_choose"><i class="livicon" data-name="plus" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="chọn"></i></a>';
                            return $actions;
                        })
                        ->rawColumns(['actions'])
                        ->make();
                    break;
                case 'topic':
                    return Datatables::of($this->topic->findAll())
                        ->addColumn('actions', function ($topic) {
                            $actions = '<a href="javascript:void(0)" c-data="' . $topic->display_name . '" data-value="' . $topic->topic_id . '" class="topic_choose"><i class="livicon" data-name="plus" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="chọn"></i></a>';
                            return $actions;
                        })
                        ->rawColumns(['actions'])
                        ->make();
                    break;
                case 'topic_round':
                    return Datatables::of($this->topic_round->findAll())
                        ->addColumn('actions', function ($topic_round) {
                            $actions = '<a href="javascript:void(0)" c-data="' . $topic_round->display_name . '" data-value="' . $topic_round->topic_round_id . '" class="choose"><i class="livicon" data-name="plus" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="chọn"></i></a>';
                            return $actions;
                        })
                        ->rawColumns(['actions'])
                        ->make();
                    break;

            }
        }

    }



//Lấy thông tin vòng thi - gói prepare
    public function getExamInfo(Request $request)
    {
        $res = [];

        if (!empty($request->type)) {
            if($request->type == 'test'){
                $arr = [];
                $arr['round'] = [];
                $round = ContestRound::query()->where('round_type', $request->type)->get();
                if ($round->count() > 0){
                    foreach ($round as $key => $item) {
                        $topic = ContestTopic::query()->where('round_id', $item->round_id)->get();
                        $start = \DateTime::createFromFormat('Y-m-d H:i:s', $item->start_date);
                        $start = $start->getTimestamp();
                        $end = \DateTime::createFromFormat('Y-m-d H:i:s', $item->end_date);
                        $end = $end->getTimestamp();
                        $arr['round'][$key] = [
                            "round_id" => 1,
                            "order" => 1,
                            "round_name" => $item->round_name,
                            "display_name" => $item->display_name,
                            "description" => $item->description,
                            "time" => [
                                "start" => $start,
                                "end" => $end,
                                "end_notify" => $item->end_notify
                            ],
                            "total_topic" => $topic->count(),
                            "topic" => []
                        ];
                        if (!empty($topic)) {
                            foreach ($topic as $key1 => $value1) {
                                $topic_start = \DateTime::createFromFormat('Y-m-d H:i:s', $value1->start_date);
                                $topic_start = $topic_start->getTimestamp();
                                $topic_end = \DateTime::createFromFormat('Y-m-d H:i:s', $value1->end_date);
                                $topic_end = $topic_end->getTimestamp();
                                $topic_round =  json_decode($value1->topic_round, true);
                                $topic_round_arr = [];
                                if(!empty($topic_round)){
                                    foreach ($topic_round as $key2=>$value2){
                                        $topic_round_arr[] = [
                                            'id' => $key2,
                                            'rule_text' => $value2['rule_text']
                                        ];
                                    }

                                }
                                $arr['round'][$key]['topic'][$key1] = [
                                    "topic_id" => $value1->topic_id,
                                    "order" => $value1->order,
                                    "topic_name" => $value1->topic_name,
                                    "display_name" => $value1->display_name,
                                    "topic_type" => $value1->type,
                                    "type" => $value1->topic_type,
                                    "rule_text" => $value1->rule_text,
                                    "time" => [
                                        "start" => $topic_start,
                                        "end" => $topic_end,
                                        "end_notify" => $value1->end_notify
                                    ],
                                    "exam_repeat_time" => $value1->exam_repeat_time,
                                    "topic_point_method" => $value1->topic_point_method,
                                    "topic_point_condition" => $value1->topic_point_condition,
                                    "topic_exam_repeat_condition" => $value1->topic_exam_repeat_condition,
                                    "exam_repeat_time_wait" => $value1->exam_repeat_time_wait,
                                    "total_time_limit" => $value1->total_time_limit,
                                    "question_pack_id" => $value1->question_pack_id,
                                    "topic_round" => $topic_round_arr
                                ];
                                if(!empty($value1->question_pack_id)){
                                    try{
                                        $quest_json_list = [];
                                        $question_pack_list = json_decode($value1->question_pack_id);
                                        foreach ($question_pack_list as $key3 => $value3){
                                            $exam_json_list = file_get_contents('http://quiz2.vnedutech.vn/admin/toolquiz/contest/get-list-json/'.$value3);
                                            $quest_json_list[] = [
                                                'target' => $key3,
                                                'json_list' => json_decode($exam_json_list,true)
                                            ];
                                        }
                                        $arr['round'][$key]['topic'][$key1]['exam_json_list'] = $quest_json_list;

                                    }
                                    catch (\Exception $e){

                                    }

                                }
                            }
                        }
                    }
                    $res['success'] = true;
                }
                else{
                    $res['success'] = false;
                }
                $data = [
                    'exam_info' => $arr
                ];
                $res['data'] = $data;
                return response()->json($res);
            }
            elseif($request->type == 'real'){
                if(!empty($request->token)){
//                    $response = file_get_contents('http://timhieubiendao.daknong.vn/verify?token=' . $request->token);
//                    $response = json_decode($response);
//                    if($response->status == true){
//                        $response_data = $response->data;
//                        if(!empty($response_data->user_id)){
                            $arr = [];
                            $arr['round'] = [];
                            $round = ContestRound::query()->where('round_type', $request->type)->get();
                            if (!empty($round)) {
                                foreach ($round as $key => $item) {
                                    $topic = ContestTopic::query()->where('round_id', $item->round_id)->get();
                                    $start = \DateTime::createFromFormat('Y-m-d H:i:s', $item->start_date);
                                    $start = $start->getTimestamp();
                                    $end = \DateTime::createFromFormat('Y-m-d H:i:s', $item->end_date);
                                    $end = $end->getTimestamp();
                                    $arr['round'][$key] = [
                                        "round_id" => $item->round_id,
                                        "order" => 1,
                                        "round_name" => $item->round_name,
                                        "display_name" => $item->display_name,
                                        "description" => $item->description,
                                        "time" => [
                                            "start" => $start,
                                            "end" => $end,
                                            "end_notify" => $item->end_notify
                                        ],
                                        "total_topic" => $topic->count(),
                                        "topic" => []
                                    ];
                                    if (!empty($topic)) {
                                        foreach ($topic as $key1 => $value1) {
                                            $topic_start = \DateTime::createFromFormat('Y-m-d H:i:s', $value1->start_date);
                                            $topic_start = $topic_start->getTimestamp();
                                            $topic_end = \DateTime::createFromFormat('Y-m-d H:i:s', $value1->end_date);
                                            $topic_end = $topic_end->getTimestamp();
                                            $topic_round =  json_decode($value1->topic_round, true);
                                            $topic_round_arr = [];
                                            if(!empty($topic_round)){
                                                foreach ($topic_round as $key2=>$value2){
                                                    $topic_round_arr[] = [
                                                        'id' => $key2,
                                                        'rule_text' => $value2['rule_text']
                                                    ];
                                                }

                                            }
                                            $arr['round'][$key]['topic'][$key1] = [
                                                "topic_id" => $value1->topic_id,
                                                "order" => $value1->order,
                                                "topic_name" => $value1->topic_name,
                                                "display_name" => $value1->display_name,
                                                "topic_type" => $value1->type,
                                                "type" => $value1->topic_type,
                                                "rule_text" => $value1->rule_text,
                                                "time" => [
                                                    "start" => $topic_start,
                                                    "end" => $topic_end,
                                                    "end_notify" => $value1->end_notify
                                                ],
                                                "exam_repeat_time" => $value1->exam_repeat_time,
                                                "exam_repeat_time_wait" => $value1->exam_repeat_time_wait,
                                                "total_time_limit" => $value1->total_time_limit,
                                                "question_pack_id" => $value1->question_pack_id,
                                                "topic_point_method" => $value1->topic_point_method,
                                                "topic_point_condition" => $value1->topic_point_condition,
                                                "topic_exam_repeat_condition" => $value1->topic_exam_repeat_condition,
                                                "topic_round" => $topic_round_arr
                                            ];
                                            if(!empty($value1->question_pack_id)){
                                                try{
                                                    $quest_json_list = [];
                                                    $question_pack_list = json_decode($value1->question_pack_id);
                                                    foreach ($question_pack_list as $key3 => $value3){
                                                        $exam_json_list = file_get_contents('http://quiz2.vnedutech.vn/admin/toolquiz/contest/get-list-json/'.$value3);
                                                        $quest_json_list[] = [
                                                            'target' => $key3,
                                                            'json_list' => json_decode($exam_json_list,true)
                                                        ];
                                                    }
                                                    $arr['round'][$key]['topic'][$key1]['exam_json_list'] = $quest_json_list;
                                                }
                                                catch (\Exception $e){

                                                }

                                            }
                                        }
                                    }
                                }
                            }
                            $data = [
                                'exam_info' => $arr
                            ];
                            $res['data'] = $data;
                            $res['success'] = true;
                            $res['messages'] = null;
                            return response()->json($res);
//                        }
//                    }
//                    else{
//                        $res['status'] = false;
//                        $res['messages'] = $response->messeger;
//                        return response()->json($res);
//                    }
                }
                else{
                    $arr = [];
                    $arr['round'] = [];
                    $round = ContestRound::query()->where('round_type', $request->type)->get();
                    if ($round->count() > 0) {
                        foreach ($round as $key => $item) {
                            $topic = ContestTopic::query()->where('round_id', $item->round_id)->get();
                            $start = \DateTime::createFromFormat('Y-m-d H:i:s', $item->start_date);
                            $start = $start->getTimestamp();
                            $end = \DateTime::createFromFormat('Y-m-d H:i:s', $item->end_date);
                            $end = $end->getTimestamp();
                            $arr['round'][$key] = [
                                "round_id" => $item->round_id,
                                "order" => 1,
                                "round_name" => $item->round_name,
                                "display_name" => $item->display_name,
                                "description" => $item->description,
                                "time" => [
                                    "start" => $start,
                                    "end" => $end,
                                    "end_notify" => $item->end_notify
                                ],
                                "total_topic" => $topic->count(),
                                "topic" => []
                            ];
                            if (!empty($topic)) {
                                foreach ($topic as $key1 => $value1) {
                                    $topic_start = \DateTime::createFromFormat('Y-m-d H:i:s', $value1->start_date);
                                    $topic_start = $topic_start->getTimestamp();
                                    $topic_end = \DateTime::createFromFormat('Y-m-d H:i:s', $value1->end_date);
                                    $topic_end = $topic_end->getTimestamp();
                                    $topic_round =  json_decode($value1->topic_round, true);
                                    $topic_round_arr = [];
                                    if(!empty($topic_round)){
                                        foreach ($topic_round as $key2=>$value2){
                                            $topic_round_arr[] = [
                                                'id' => $key2,
                                                'rule_text' => $value2['rule_text']
                                            ];
                                        }

                                    }
                                    $arr['round'][$key]['topic'][$key1] = [
                                        "topic_id" => $value1->topic_id,
                                        "order" => $value1->order,
                                        "topic_name" => $value1->topic_name,
                                        "display_name" => $value1->display_name,
                                        "topic_type" => $value1->type,
                                        "type" => $value1->topic_type,
                                        "rule_text" => $value1->rule_text,
                                        "time" => [
                                            "start" => $topic_start,
                                            "end" => $topic_end,
                                            "end_notify" => $value1->end_notify
                                        ],
                                        "exam_repeat_time" => $value1->exam_repeat_time,
                                        "exam_repeat_time_wait" => $value1->exam_repeat_time_wait,
                                        "total_time_limit" => $value1->total_time_limit,
                                        "question_pack_id" => $value1->question_pack_id,
                                        "topic_point_method" => $value1->topic_point_method,
                                        "topic_point_condition" => $value1->topic_point_condition,
                                        "topic_exam_repeat_condition" => $value1->topic_exam_repeat_condition,
                                        "topic_round" => $topic_round_arr
                                    ];
                                    if(!empty($value1->question_pack_id)){
                                        try{
                                            $quest_json_list = [];
                                            $question_pack_list = json_decode($value1->question_pack_id);
                                            foreach ($question_pack_list as $key3 => $value3){
                                                $exam_json_list = file_get_contents('http://quiz2.vnedutech.vn/admin/toolquiz/contest/get-list-json/'.$value3);
                                                $quest_json_list[$key3] = json_decode($exam_json_list,true);
                                            }
                                            $arr['round'][$key]['topic'][$key1]['exam_json_list'] = $quest_json_list; $quest_json_list = [];
                                            $question_pack_list = json_decode($value1->question_pack_id);
                                            foreach ($question_pack_list as $key3 => $value3){
                                                $exam_json_list = file_get_contents('http://quiz2.vnedutech.vn/admin/toolquiz/contest/get-list-json/'.$value3);
                                                $quest_json_list[] = [
                                                    'target' => $key3,
                                                    'json_list' => json_decode($exam_json_list,true)
                                                ];
                                            }
                                            $arr['round'][$key]['topic'][$key1]['exam_json_list'] = $quest_json_list;
                                        }
                                        catch (\Exception $e){

                                        }

                                    }
                                }
                            }
                        }
                        $res['success'] = true;
                    }
                    else{
                        $res['success'] = false;
                    }
                    $data = [
                        'exam_info' => $arr
                    ];
                    $res['data'] = $data;
                    $res['messages'] = null;
                    return response()->json($res);
                }
            }

        }
    }
//Lấy thông tin thi của thí sinh
    public function getUserInfo(Request $request){
        if(!empty($request->user_id)){
            $info = UserContestInfo::where('user_id','=',$request->user_id)->first();
            if(empty($info)){
                $info = new UserContestInfo();
                $info->user_id = $request->user_id;
                $info->is_lock = false;
                $current_exam = [
                    'round' => 0,
                    'topic' => 0,
                    'times' => 0,
                    'success' => 0
                ];
                $info->current_exam = $current_exam;
                $exam_result = [];
                $round_list = ContestRound::where(['round_type' => 'real', 'status' => '1'])->get();
                if(!empty($round_list)){
                    foreach ($round_list as $key => $item) {
                        $exam_result[$item->round_id] = [];
                        $topic_list = ContestTopic::where(['round_id' => $item->round_id, 'status' => '1'])->get();
                        if(!empty($topic_list)){
                            foreach ($topic_list as $key1 => $item1) {
                                $exam_result[$item->round_id][$item1->topic_id] = [];
                                if($item1->exam_repeat_time >0){
                                    for($i = 0;$i <= $item1->exam_repeat_time;$i++){
                                        $exam_result[$item->round_id][$item1->topic_id][] = [
                                            'times' => $i+1,
                                            'time_start' => 0,
                                            'time' => -1,
                                            'point' => -1,
                                            'success' => 0
                                        ];
                                    }
                                }
                                else{
                                    $exam_result[$item->round_id][$item1->topic_id][] = [
                                        'times' => 1,
                                        'time_start' => 0,
                                        'time' => -1,
                                        'point' => -1,
                                        'success' => 0
                                    ];
                                }
                            }
                        }
                    }
                }
                $info->exam_result = $exam_result;
                $info->save();
                return response()->json($info);
            }
            else{
                if(!empty($request->round_id)){
                    if(!empty($request->topic_id)){

                    }
                    else{

                    }
                }
                else{
                   $current_exam = $info->current_exam;
                   return response()->json($current_exam);
                }
            }
        }
        else{

        }
    }

    public function updateUserInfo(Request $request){

    }
//Lấy list kết quả thi theo user_id
    public function getContestResult(Request $request){
        $res = [
            'success' => false,
            'data' => null,
            'messages' => ''
        ];
        $user_info = [];
//        $result = ContestResultJava::select('user_id','round_id','topic_id','repeat_time','total_point','finish_time','used_time')->where('user_id', $request->user_id)->where('finish_time','!=',null)->orderBy('finish_time','asc')->get()->toArray();
        $result = ContestResult::where('member_id', (int)$request->user_id)->get()->toArray();
        $table_data = RankBoard::where(['type' => 'view', 'params' => 'exam_result'])->first();
        $user = UserContestInfo::where('member_id', (int)$request->user_id)->first();
        if(!empty($user)){
            $user_config = ContestSetting::where('param','user_info')->first();
            if(!empty($user_config)){
                foreach ($user_config->data as $key2 => $value2){
                    $key = $value2['key'];
                    $user_info[] = [
                        'title' => $value2['value'],
                        'value' => $user->$key
                    ];
                }
            }
        }
        $headers = [];
        if(!empty($result)) {
            $data_array = [];
            foreach ($result as $key => $value) {
                $round_name = '';
                $topic_name = '';
                if (!empty($value['round_id'])) {
                    $round = $this->round->find((int)$value['round_id']);
                    if (!empty($round)) {
                        $round_name = $round->display_name;
                    }
                }
                if (!empty($value['topic_id'])) {
                    $topic = $this->topic->find((int)$value['topic_id']);
                    if (!empty($topic)) {
                        $topic_name = $topic->display_name;
                    }
                }
                $result[$key]['round_name'] = base64_decode($round_name);
                $result[$key]['topic_name'] = $topic_name;
                $result[$key]['used_time'] = !empty($value['used_time'])?(new ContestFunc())->convertExamTime((int)$value['used_time']):'';
            }
            if (!empty($table_data)) {
                foreach ($table_data->header as $key3 => $item3) {
                    $headers[] = $item3['title'];
                }
                $idx = 1;
                foreach ($result as $key1 => $item1) {
                    $data_array[$key1] = [];
                    $data_array[$key1][] = $idx++;
                    foreach ($table_data->header as $key4 => $item4) {
                        if(isset($item1[$item4['param']])){
                            $data_array[$key1][] = $item1[$item4['param']] ;
                        }
                    }

                }
            }

            $res['title'] = $table_data->title;
            $res['data'] = $data_array;
            $res['user_info'] = $user_info;
            $res['success'] = true;
        }
        else{
            $res['messages'] = 'User chưa tham gia thi';
            $res['success'] = true;
            if (!empty($table_data)) {
                foreach ($table_data->header as $key3 => $item3) {
                    $headers[] = $item3['title'];
                }
            }
        }
        $res['headers'] = $headers;
        return response()->json($res);
    }

    public function getQuestionPack(Request $request){
        $res = [
            'success' => false,
            'data' => null,
            'messages' => ''
        ];
        if(!empty($request->topic_id)){
            $topic = $this->topic->find((int)$request->topic_id);
            if($topic){
                $res['success'] = true;
                $res['data'] = new \stdClass();
                $res['data']->question_pack_id = (int)$topic->question_pack_id;
            }
            else{
                $res['messages'] = 'Topic not found';
            }
        }
        else{
            $res['messages'] = 'Missing topic';
        }
        return response()->json($res);
    }
//Build json load các form động
    public function getLoadForm(Request $request){
        $res = [];
        $data_type = file_get_contents('http://cuocthi.vnedutech.vn/api/contest/get/type_config');
        $html_type = [];
        $type = [];
        if(!empty($data_type)){
            $data_type = json_decode($data_type, true);
            if(!empty($data_type['data'])){
                $html_type = (object)$data_type['data']['html_type_list'];
                $type = $data_type['data']['type'];
            }
        }
        $res['config'] = $html_type;
        if(!empty($request->type)){
            $target = FormLoad::where('alias',$request->type)->first();
        }
        else{
            $target = ContestTarget::first();
        }
        if(!empty($target)){
            $res['success'] = true;
            $res['data'] = new \stdClass();
            $res['data']->load_default = [];
            if(!empty($target->general)){
                $idx = -1;
                foreach ($target->general as $key => $value){
                    $value['type_view'] = $value['type_id'];
                    $idx++;
                    ($res['data']->load_default)[$idx] = (object)$value;
                    if(!empty((($res['data']->load_default)[$idx])->params_hidden) && (($res['data']->load_default)[$idx])->params_hidden == null){
                        (($res['data']->load_default)[$idx])->params_hidden = "";
                    }
                }
            }
//            $res['data']->load_default = $target->general;
            $res['data']->auto_load = [];
            if(!empty($target->target)){
                $res['data']->auto_load[0] = new \stdClass();
                ($res['data']->auto_load[0])->id = 1;
                ($res['data']->auto_load[0])->title = 'Cấp học';
                ($res['data']->auto_load[0])->params = 'target';
                ($res['data']->auto_load[0])->type_view = 4;
                ($res['data']->auto_load[0])->type = 'auto';
                ($res['data']->auto_load[0])->type_id = 1;
                ($res['data']->auto_load[0])->data_type = "string";
                ($res['data']->auto_load[0])->is_require = true;
                ($res['data']->auto_load[0])->form_data = [];
                $idx = -1;
                foreach ($target->target as $key2 => $value2){
                    $idx ++;
                    (($res['data']->auto_load[0])->form_data)[$idx] = new \stdClass();
                    ((($res['data']->auto_load[0])->form_data)[$idx])->id = $key2;
                    ((($res['data']->auto_load[0])->form_data)[$idx])->title = $value2['name'];
                    ((($res['data']->auto_load[0])->form_data)[$idx])->type_view = 1;
                    ((($res['data']->auto_load[0])->form_data)[$idx])->type = 'auto';
                    ((($res['data']->auto_load[0])->form_data)[$idx])->type_id = 1;
                    ((($res['data']->auto_load[0])->form_data)[$idx])->data_type = "string";
                    ((($res['data']->auto_load[0])->form_data)[$idx])->is_require = true;
                    ((($res['data']->auto_load[0])->form_data)[$idx])->form_data = [];
                    $idx1 = -1;
                    ($res['data']->auto_load[0])->order = (array_values($value2['field'])[0])['order'];
                    foreach ($value2['field'] as $key3 => $value3) {
                        $idx1 ++;
                        (((($res['data']->auto_load[0])->form_data)[$idx])->form_data)[$idx1] = (object)$value3;
                        ((((($res['data']->auto_load[0])->form_data)[$idx])->form_data)[$idx1])->type_view =  (int)((((($res['data']->auto_load[0])->form_data)[$idx])->form_data)[$idx1])->type_id;
                        if(!empty(((((($res['data']->auto_load[0])->form_data)[$idx])->form_data)[$idx1])->params_hidden) && ((((($res['data']->auto_load[0])->form_data)[$idx])->form_data)[$idx1])->params_hidden == null){
                            ((((($res['data']->auto_load[0])->form_data)[$idx])->form_data)[$idx1])->params_hidden = "";
                        }

                    }
                }
            }
        }

        $res['messages'] = '';
        return response()->json($res);
    }
//Kiểm tra thí sinh đã cập nhật thông tin hay chưa
    public function checkRegister(Request $request){
        $res = [
            'success' => false,
            'messages' => ''
        ];
        if(!empty($request->member_id)){
            $member = UserContestInfo::where('member_id', (int)$request->member_id)->count();
            if($member > 0){
                $res['success'] = true;
            }
            else{
                $res['messages'] = 'member not found';
            }
        }
        elseif(!empty($request->u_name)){
            $member = UserContestInfo::where('u_name', $request->u_name);
            if(!empty($member)){
                $res['success'] = true;
            }
            else{
                $res['messages'] = 'member not found';
            }
        }
        else{
            $res['messages'] = 'member_id not found';
        }
        return response()->json($res);
    }
//Lấy danh sách thí sinh cập nhật thông tin gần nhất
    public function getRecentReg(Request $request){
        $res = [
            'success' => false,
            'data' => null,
            'messages' => null
        ];
        $limit = !empty($request->limit)?(int)$request->limit:5;
        $list = UserContestInfo::orderBy('_id','desc')->take($limit)->get();
        if(!empty($list)){
            $res['success'] = true;
            $res['data'] = $list;
        }
        return response()->json($res);
    }
//Tra cứu thí sinh
    public function searchCandidate(Request $request)
    {
        $cond = [];
//        $cond['finish_exam'] = true;
        if (!empty($request->province_id) && $request->province_id != 0) {
            $cond['province_id'] = (int)$request->province_id;
        }
        if (!empty($request->district_id) && $request->district_id != 0) {
            $cond['district_id'] = (int)$request->district_id;
        }
        if (!empty($request->school_id) && $request->school_id != 0) {
            $cond['school_id'] = (int)$request->school_id;
        }
        if (!empty($request->class_id) && $request->class_id != 0) {
            $cond['class_id'] = (int)$request->class_id;
        }
        if (!empty($request->table_id) && $request->table_id != 0) {
            $cond['table_id'] = (int)$request->table_id;
        }
        if (!empty($request->u_name)) {
            $cond['u_name'] = $request->u_name;
        }
        $limit = !empty($request->limit) ? (int)$request->limit : 20;
        if (!empty($request->name)) {
            $result = UserContestInfo::where($cond)->where('name','like','%'.$request->name.'%')->paginate($limit);
        }
        else{
            $result = UserContestInfo::where($cond)->paginate($limit);
        }
        if(!empty($cond)){
            $res =  $result->withPath(config('app.url').'/admin/api/contest/search_contest_result?'. http_build_query($cond));
        }
        else{
            $res =  $result->withPath(config('app.url').'/admin/api/contest/search_contest_result');
        }

        $res_data = json_decode($res->toJson());
        $headers = [];
        $table_data = RankBoard::where(['type' => 'search', 'params' => 'candidate'])->first();
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
                                $data_array[$key][] = $item2;
                            }
                        }
                    }
                }
                $res_data->data = $data_array;
            }
            $res_data->headers = $headers;
            $res_data->success = true;
        }
        return response()->json($res_data);

    }
//Build json BXH, top
    public function getRankBoard(Request $request){
        $tag = 'limit';
        if(!empty($request->limit)) {
            $tag = $tag . $request->limit;
        }
        if(!empty($request->reload_cache)){
            if(Cache::tags([$tag])->has('rank_board')){
                Cache::tags([$tag])->forget('rank_board');
            }
        }
            if(Cache::tags([$tag])->has('rank_board')){
                $resp = Cache::tags([$tag])->get('rank_board');
            }
            else{
                if(empty($resp)){
                    $resp = [
                        'success' => false,
                        'data' => [],
                        'messages' => ''
                    ];
                    $limit = !empty($request->limit)?$request->limit:5;
                    $rank_board = RankBoard::where('type', "top")->get();
                    $data = [];
                    $res_data = [];
                    if(!empty($rank_board)){
                        foreach ($rank_board as $key => $value){
                            $data_child = [];
                            if(!empty($value->data_child)){
                                foreach ($value->data_child as $key1 => $value1){
                                    $data_child[$key1] = new \stdClass();
                                    $data_child[$key1]->title = $value1['title'];
                                    $data_child[$key1]->params = $value1['params'];
                                    $data_child[$key1]->table_header = $value1['headers'];
                                    $client = new Client();
                                    $top = !empty($request->limit)?$request->limit:$value1['limit'];
                                    $res = ($client->request('GET', config('app.url').'/api/contest/get/top/'.$value->params.'?top_type='.$value1['params'].'&top='.$top.'&page=1'))->getBody()->getContents();
                                    if(!empty($res)){
                                        $res = json_decode($res);
                                        $data_child[$key1]->data_table = $res->data;
                                        $data_child[$key1]->total_record= $res->total_record;
                                        $data_child[$key1]->total_page= $res->total_page;
                                    }
                                    $data_child[$key1]->api = config('app.url').'/api/contest/get/top/'.$value->params.'?top_type='.$value1['params'];

                                }
                            }
                            if(!empty($value->header)){
                                $res = ($client->request('GET', config('app.url').'/api/contest/get/top/'.$value->params.'?top='.$limit.'&page=1'))->getBody()->getContents();
                                if(!empty($res)){
                                    $res = json_decode($res);
                                    $res_data[] = [
                                        'data_table' => $res->data,
                                        'total_record' => $res->total,
                                        'total_page' => $res->last_page,
                                        'table_header' => $res->headers,
                                        'api' => "",
                                        'params' => "",
                                        'title' => ""
                                    ];
                                }
                            }
                            $data[$key] = [
                                'title' => $value->title,
                                'params' => $value->params,
                                'data_child' => $data_child,
                                'data' => $res_data
                            ];

                        }
                        $resp['success'] = true;
                        $resp['data'] = $data;
                        Cache::tags([$tag])->put('rank_board',$resp,30);
                    }

                }
            }


       return response()->json($resp);
    }
//Lấy list vòng thi, tuần thi...
    public function getDataList(Request $request){
        $res = [
            'success' => false,
            'data' => [],
            'messages' => ''
        ];
        if(!empty($request->type)){
            if($request->type =='round'){
                $data = ContestRound::where('round_type','real')->get();
                if(!empty($data)){
                    foreach ($data as $key => $item) {
                        $res['data'][] = [
                            'key' => $item->round_id,
                            'value' => base64_decode($item->display_name)
                        ];
                        $res['success'] = true;
                    }
                }
            }
            elseif($request->type =='topic'){
                if(!empty($request->round_id)){
                    $data = ContestTopic::where('round_id', (int)$request->round_id)->where('topic_type','real')->get();
                }
                else{
                    $data = ContestTopic::all();
                }
                if(!empty($data)){
                    foreach ($data as $key => $item) {
                        $res['data'][] = [
                            'key' => $item->topic_id,
                            'value' => $item->display_name
                        ];
                        $res['success'] = true;
                    }
                }
            }
        }
        return response()->json($res);
    }

    public function getTotal(Request $request){
        if(!empty($request->type)){
            if($request->type == 'register'){
                $result = UserContestInfo::count();
            }
            elseif($request->type == 'candidate'){
                $result = ContestResult::all()->groupBy('member_id')->count();
            }
            return $result;
        }
    }

    public function testCORS(){
        return response()->json(file_get_contents('http://quiz2.vnedutech.vn/admin/api/contest/list_contest'));
    }
}