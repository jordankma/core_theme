<?php

namespace Contest\Contestmanage\App\Http\Controllers;

use Adtech\Application\Cms\Controllers\Controller as Controller;
use Contest\Contestmanage\App\Models\ContestResult;
use Contest\Contestmanage\App\Models\ContestRound;
use Contest\Contestmanage\App\Models\ContestTopic;
use Contest\Contestmanage\App\Models\UserContestInfo;
use Contest\Contestmanage\App\Repositories\ContestRoundRepository;
use Contest\Contestmanage\App\Repositories\ContestSeasonRepository;
use Contest\Contestmanage\App\Repositories\ContestTopicRepository;
use Contest\Contestmanage\App\Repositories\TopicRoundRepository;
use Illuminate\Http\Request;
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

    public function getExamInfo(Request $request)
    {
        $res = [];

        if (!empty($request->type)) {
            if($request->type == 'test'){
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
                                    "exam_repeat_time_wait" => $value1->exam_repeat_time_wait,
                                    "total_time_limit" => $value1->total_time_limit,
                                    "question_pack_id" => $value1->question_pack_id,
                                    "topic_round" => $topic_round_arr
                                ];
                            }
                        }
                    }
                }
                $data = [
                    'exam_info' => $arr
                ];
                $res['data'] = $data;
                return response()->json($res);
            }
            elseif($request->type == 'real'){
                if(!empty($request->token)){
                    $response = file_get_contents('http://timhieubiendao.daknong.vn/verify?token=' . $request->token);
                    $response = json_decode($response);
                    if($response->status == true){
                        $response_data = $response->data;
                        if(!empty($response_data->user_id)){
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
                                                "topic_round" => $topic_round_arr
                                            ];
                                        }
                                    }
                                }
                            }
                            $data = [
                                'exam_info' => $arr
                            ];
                            $res['data'] = $data;
                            $res['status'] = true;
                            $res['messages'] = null;
                            return response()->json($res);
                        }
                    }
                    else{
                        $res['status'] = false;
                        $res['messages'] = $response->messeger;
                        return response()->json($res);
                    }
                }
                else{
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
                                        "topic_round" => $topic_round_arr
                                    ];
                                }
                            }
                        }
                    }
                    $data = [
                        'exam_info' => $arr
                    ];
                    $res['data'] = $data;
                    $res['status'] = true;
                    $res['messages'] = null;
                    return response()->json($res);
                }
            }

        }
    }

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
                    'status' => 0
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
                                            'status' => 0
                                        ];
                                    }
                                }
                                else{
                                    $exam_result[$item->round_id][$item1->topic_id][] = [
                                        'times' => 1,
                                        'time_start' => 0,
                                        'time' => -1,
                                        'point' => -1,
                                        'status' => 0
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

    public function getContestResult(Request $request){
        $result = ContestResult::where('user_id', $request->user_id)->get()->toArray();
        foreach ($result as $key => $value) {
//            $round = $this->round->find($value['current_round']);
            $result[$key]['round_name'] = 'Vòng thi thứ nhất: Thi trắc nghiệm cá nhân';
            $result[$key]['topic_name'] = 'Tuần 1';
        }
        return response()->json($result);
    }

    public function getQuestionPack(Request $request){
        $res = [
            'status' => false,
            'data' => null,
            'messages' => ''
        ];
        if(!empty($request->topic_id)){
            $topic = $this->topic->find((int)$request->topic_id);
            if($topic){
                $res['status'] = true;
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

}