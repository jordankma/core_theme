<?php

namespace Contest\Exam\App\Http\Controllers;

use Contest\Contestmanage\App\Models\ContestResult;
use Contest\Contestmanage\App\Models\ContestRound;
use Contest\Contestmanage\App\Models\ContestTopic;
use Contest\Contestmanage\App\Models\UserContestInfo;
use Contest\Contestmanage\App\Repositories\ContestResultRepository;
use Contest\Contestmanage\App\Repositories\ContestRoundRepository;
use Contest\Contestmanage\App\Repositories\ContestTopicRepository;
use Contest\Exam\App\ApiHash;
use Contest\Exam\App\Models\ExamData;
use Contest\Exam\App\Repositories\ExamDataRepository;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Illuminate\Support\Facades\DB;

class ExamController extends Controller
{

    public function __construct(ExamDataRepository $examDataRepository, ContestRoundRepository $contestRoundRepository, ContestTopicRepository $contestTopicRepository, ContestResultRepository $contestResultRepository)
    {
        parent::__construct();
        $this->examData = $examDataRepository;
        $this->round = $contestRoundRepository;
        $this->topic = $contestTopicRepository;
        $this->result = $contestResultRepository;
        $this->quiz2_url = 'http://quiz2.vnedutech.vn/json/contest/';
    }

//    function getCurrentExamByTime(){
//        $round = $this->round->findCurrentRound(time());
//
//    }

    public function prepare(Request $request)
    {
        $res = [
            'success' => false,
            'messages' => "",
            'data' => null
        ];
        $last_exam = null;
        $res_data = [];
        $topic_data = [];
        $exam_lock = 0; //1:không đủ điều kiện thi, không được thi
        $exam_status = 0;//0:free, 1:đang thi,chưa hoàn thành

//        $test = [
//            'user_id' => 12493784,
//            'token' => '7gq9VNNvO5oYNWS7JaMu9UDks1AqhkEbNoBNezz5yWwOTB9XflYM51x63hj8',
//            'type' => 'real'
//        ];
//        echo '<pre>';print_r((new ApiHash(env('SECRET_KEY'), env('SECRET_IV')))->encrypt(json_encode($test)));echo '</pre>';die;

        $data = !empty((new ApiHash(env('SECRET_KEY'), env('SECRET_IV')))->decrypt($request->data)) ? json_decode((new ApiHash(env('SECRET_KEY'), env('SECRET_IV')))->decrypt($request->data)) : null;
        if (!empty($data->token)) {
// verify token eid
            $client = new Client();
            $headers = [
                'Authorization' => 'Bearer ' . env('BEARER_TOKEN'),
                'Accept'        => 'application/json',
            ];
            $check = $client->request('GET', 'http://eid.vnedutech.vn/api/verify?token=' . $data->token, [
                'headers' => $headers
            ]);
            $check = $check->getBody()->getContents();
            $check = !empty($check) ? json_decode($check) : null;
// end verify
            if($check && $check->success == true){
//           if($check){
                if ($data->user_id) {
                    if($check->data->user_id == $data->user_id){
                        $user_check = UserContestInfo::where('member_id', (int)$data->user_id)->first();
                        if ($user_check) {
                            if (!empty($data->type)) {
                                if ($this->examData->isExist()) {
                                    $last_exam = $this->examData->getLastExam((int)$data->user_id);
                                    if (!empty($last_exam) && $last_exam->status == 1) {
                                        $exam_status = 1;
                                    }
                                }
                                $curr_round = $this->round->findCurrentRound(time(), $data->type);
                                if (!empty($curr_round)) {
                                    if($data->type == 'test'){
                                        $exam_lock = 0;
                                    }
                                    else{
                                        $round_field = 'round_'.$curr_round->round_id.'_status';
                                        if(!empty($user_check->$round_field)){
                                            if($user_check->$round_field == 1){
                                                $exam_lock = 0;
                                            }
                                            else{
                                                if($curr_round->order == 1){
                                                    $exam_lock = 0;
                                                }
                                                else{
                                                    $exam_lock = 1;
                                                }
                                            }
                                        }
                                        else{
                                            if($curr_round->order == 1){
                                                $exam_lock = 0;
                                            }
                                            else{
                                                $exam_lock = 1;
                                            }
                                        }
                                    }


                                    if($exam_lock == 1){
                                        $res['messages'] = "Không đủ diều kiện tham gia vòng thi này";
                                    }
                                    else{
                                        $exam_info['round'] = $curr_round;
                                        $curr_round_id = $curr_round->round_id;
                                        $curr_topic = $this->topic->findCurrentTopic(time(), $data->type, (int)$curr_round_id);
//                                  Nếu có nhiều tuần thi đang diễn ra
                                        if ($curr_topic->count() > 1) {
                                            $exam_info['round']->topic = [];
                                            foreach ($curr_topic as $key1 => $value1) {
                                                $user_data = [];
                                                $total_repeat_time = $this->topic->totalRepeatTime($value1->topic_id);
                                                $total_exam_time = $this->examData->countRepeatTime($curr_round_id, $value1->topic_id,$user_check->member_id);
                                                if($exam_status == 1){
                                                    if(!empty($data->device_id)){
                                                        if($data->device_id == $last_exam->device_id){
                                                            $user_data['status'] = false;
                                                            $user_info['messages'] = "Reconnect";
                                                        }
                                                        else{
                                                            $user_data['status'] = 3;
                                                            $user_info['messages'] = "Có lượt thi chưa hoàn thành trên thiết bị khác!";
                                                        }
                                                    }
                                                    $user_data['status'] = false;
                                                    $res['messages'] = "Có lượt thi chưa hoàn thành trên thiết bị khác!";
                                                }
                                                else{
                                                    if ($total_repeat_time == 0) {
                                                        $user_data['status'] = true;
                                                        if (!empty($user_check->target)) {
                                                            $question_pack_id = (int)(json_decode($value1->question_pack_id, true))[$user_check->target];
                                                        } else {
                                                            $question_pack_id = (int)$value1->question_pack_id;
                                                        }
                                                        $user_data['clone_id'] = $this->getQuestionExam($data->user_id, $question_pack_id, $data->type);
                                                        $user_data['exam_question_url'] = !empty($user_data['clone_id']) ? base64_encode($this->quiz2_url . $question_pack_id . '/' . $user_data['clone_id'] . '_file.json?v=' . time()) : "";
                                                    }
                                                    else {
                                                        if ($total_repeat_time > $total_exam_time) {
                                                            $user_data['status'] = true;
                                                            if (!empty($user_check->target)) {
                                                                $question_pack_id = (int)(json_decode($value1->question_pack_id, true))[$user_check->target];
                                                            } else {
                                                                $question_pack_id = (int)$value1->question_pack_id;
                                                            }
                                                            $user_data['clone_id'] = $this->getQuestionExam($data->user_id, $question_pack_id, $data->type);
                                                            $user_data['exam_question_url'] = !empty($user_data['clone_id']) ? base64_encode($this->quiz2_url . $question_pack_id . '/' . $user_data['clone_id'] . '_file.json?v=' . time()) : "";
                                                        }
                                                        else {
                                                            $user_info['status'] = false;
                                                            $user_info['messages'] = 'Hết lượt thi';
                                                        }
                                                    }
                                                }
                                                $value1->topic_round = json_decode($value1->topic_round);
                                                $topic_data[] = [
                                                    'topic_info' => $value1,
                                                    'user_data' => $user_data
                                                ];
                                            }
                                            $exam_info['round']->topic = $topic_data;
                                            $res['success'] = true;
                                        }
//                                    Nếu có 1 tuần thi đang diễn ra
                                        elseif ($curr_topic->count() == 1) {
                                            $curr_topic = $curr_topic[0];
                                            $curr_topic->topic_round = json_decode($curr_topic->topic_round);
                                            //Nếu không phải tuần thi đầu tiên
                                            if($curr_topic->order != 1){
                                                $prev_topic = $this->topic->getTopicByOrder($curr_round_id, ($curr_topic->order - 1));
                                                if($exam_status == 1){
                                                    if(!empty($data->device_id)){
                                                        if($data->device_id == $last_exam->device_id){
                                                            $user_data['status'] = 2;
                                                            $res['messages'] = "Reconnect";
                                                        }
                                                        else{
                                                            $user_data['status'] = 3;
                                                            $res['messages'] = "Có lượt thi chưa hoàn thành trên thiết bị khác!";
                                                        }
                                                    }
                                                    $user_data['status'] = false;
                                                    $res['messages'] = "Có lượt thi chưa hoàn thành trên thiết bị khác!";
                                                }
                                                else{
                                                    $user_data['status'] = true;
                                                    if($curr_topic->topic_point_condition != 0 ){
                                                        if(!empty($prev_topic)){
                                                            $prev_topic_point = $this->result->getTopicPointByCondition($data->user_id, $prev_topic->topic_id, $prev_topic->topic_point_method);
                                                            if($prev_topic_point){
                                                                if($prev_topic_point >= $curr_topic->topic_point_condition){
                                                                    $user_data['status'] = true;
                                                                    if(!empty($user_check->target)){
                                                                        $question_pack_id = (int)(json_decode($curr_topic->question_pack_id,true))[$user_check->target];
                                                                    }
                                                                    else{
                                                                        $question_pack_id = (int)$curr_topic->question_pack_id;
                                                                    }
                                                                    $user_data['clone_id'] = $this->getQuestionExam($data->user_id, $question_pack_id, $data->type);
                                                                    $user_data['exam_question_url'] = !empty($user_info['clone_id']) ? base64_encode($this->quiz2_url . $question_pack_id . '/' . $user_data['clone_id'] . '_file.json?v=' . time()) : "";
                                                                }
                                                                else{
                                                                    $user_data['status'] = false;
                                                                    $res['messages'] = 'Không đủ điều kiện thi';
                                                                }
                                                            }
                                                            else{
                                                                $user_data['status'] = false;
                                                                $res['messages'] = 'Không đủ điều kiện thi';
                                                            }
                                                        }
                                                        else{
                                                            $user_data['status'] = false;
                                                            $res['messages'] = 'Không tìm thấy tuần thi trước';
                                                        }
                                                    }
                                                    if($curr_topic->topic_exam_repeat_condition != 0 ){
                                                        if(!empty($prev_topic)){
                                                            $prev_topic_total_repeat = $this->result->getTopicTotalRepeat($data->user_id, $prev_topic->topic_id);
                                                            if($prev_topic_total_repeat){
                                                                if($prev_topic_total_repeat >= $curr_topic->topic_exam_repeat_condition){
                                                                    $user_data['status'] = true;
                                                                    if(!empty($user_check->target)){
                                                                        $question_pack_id = (int)(json_decode($curr_topic->question_pack_id,true))[$user_check->target];
                                                                    }
                                                                    else{
                                                                        $question_pack_id = (int)$curr_topic->question_pack_id;
                                                                    }
                                                                    $user_data['clone_id'] = $this->getQuestionExam($data->user_id, $question_pack_id, $data->type);
                                                                    $user_data['exam_question_url'] = !empty($user_info['clone_id']) ? base64_encode($this->quiz2_url . $question_pack_id . '/' . $user_data['clone_id'] . '_file.json?v=' . time()) : "";

                                                                }
                                                                else{
                                                                    $user_data['status'] = false;
                                                                    $res['messages'] = 'Không đủ điều kiện thi';
                                                                }
                                                            }
                                                            else{
                                                                $user_data['status'] = false;
                                                                $res['messages'] = 'Không đủ điều kiện thi';
                                                            }
                                                        }
                                                        else{
                                                            $user_data['status'] = false;
                                                            $res['messages'] = 'Không tìm thấy tuần thi trước';
                                                        }
                                                    }
                                                }

                                            }
                                            //Nếu là tuần thi đầu tiên
                                            else{
                                                $curr_topic_id = $curr_topic->topic_id;
                                                $total_repeat_time = $this->topic->totalRepeatTime($curr_topic_id);
                                                $total_exam_time = $this->examData->countRepeatTime($curr_round_id, $curr_topic_id,$user_check->member_id);
                                                if ($total_repeat_time == 0) {
                                                    $user_data['status'] = true;
                                                    if (!empty($user_check->target)) {
                                                        $question_pack_id = (int)(json_decode($curr_topic->question_pack_id, true))[$user_check->target];
                                                    } else {
                                                        $question_pack_id = (int)$curr_topic->question_pack_id;
                                                    }
                                                    $user_data['clone_id'] = $this->getQuestionExam($data->user_id, $question_pack_id, $data->type);
                                                    $user_data['exam_question_url'] = !empty($user_data['clone_id']) ? base64_encode($this->quiz2_url . $question_pack_id . '/' . $user_data['clone_id'] . '_file.json?v=' . time()) : "";
                                                }
                                                else {
                                                    if ($total_repeat_time > $total_exam_time) {
                                                        $user_data['status'] = true;
                                                        if(!empty($user_check->target)){
                                                            $question_pack_id = (int)(json_decode($curr_topic->question_pack_id,true))[$user_check->target];
                                                        }
                                                        else{
                                                            $question_pack_id = (int)$curr_topic->question_pack_id;
                                                        }
                                                        $user_data['clone_id'] = $this->getQuestionExam($data->user_id, $question_pack_id, $data->type);
                                                        $user_data['exam_question_url'] = !empty($user_data['clone_id']) ? base64_encode($this->quiz2_url . $question_pack_id . '/' . $user_data['clone_id'] . '_file.json?v=' . time()) : "";
                                                    }
                                                    else {
                                                        $user_data['status'] = false;
                                                        $res['messages'] = 'Hết lượt thi';
                                                    }
                                                }
                                            }
                                            $exam_info['round']->topic = [
                                                0 => [
                                                    'topic_info' => $curr_topic,
                                                    'user_data' => $user_data
                                                ]
                                            ];
                                            $res['success'] = true;
                                        }
                                        else {
                                            $res['success'] = false;
                                            $res['messages'] = 'Tuần thi chưa mở';
                                        }
                                        $res['data'] = $exam_info;
                                    }

                                }
                                else {
                                    $res['success'] = false;
                                    $res['messages'] = 'Không có vòng thi nào đang diễn ra';
                                }
                            }
                            else {
                                $res['success'] = false;
                                $res['messages'] = 'Invalid type';
                            }

                        }
                        else {
                            $res['success'] = false;
                            $res['messages'] = 'Chưa đăng ký thông tin cá nhân';
                        }
                    }
                    else{
                        $res['success'] = false;
                        $res['messages'] = 'Invalid user';
                    }

                }
                else {
                    $res['success'] = false;
                    $res['messages'] = 'Invalid user_id';
                }
            }
            else {
                $res['success'] = false;
                $res['messages'] = 'Invalid user';
            }
        }
        else {
            $res['success'] = false;
            $res['messages'] = 'Invalid token';
        }
        return response()->json($res);
    }

    public function start(Request $request)
    {
        $time = (int)(time()*1000);
        $res = [
            'success' => false,
            'data' => [
                'start_time' => $time
            ],
            'messages' => ''
        ];
        $data = !empty((new ApiHash(env('SECRET_KEY'), env('SECRET_IV')))->decrypt($request->data)) ? json_decode((new ApiHash(env('SECRET_KEY'), env('SECRET_IV')))->decrypt($request->data)) : null;
        if (!empty($data->token)) {
// verify token eid
            $client = new Client();
            $headers = [
                'Authorization' => 'Bearer ' . env('BEARER_TOKEN'),
                'Accept' => 'application/json',
            ];
            $check = $client->request('GET', 'http://eid.vnedutech.vn/api/verify?token=' . $data->token, [
                'headers' => $headers
            ]);
            $check = $check->getBody()->getContents();
            $check = !empty($check) ? json_decode($check) : null;
// end verify
            if ($check && $check->success == true) {
                if ($check->data->user_id == $data->user_id) {
                    $user_check = UserContestInfo::where('member_id', (int)$data->user_id)->first();
                    if ($user_check) {
                        $last_exam = $this->examData->getLastExam((int)$data->user_id);
                        if (!empty($last_exam) && $last_exam->status == 1) {

                            $res['success'] = false;
                            $res['messages'] = 'Có lượt thi chưa kết thúc';
                        } else {
                            if (!empty($data->round_id)) {
                                if (!empty($data->topic_id)) {
                                    $curr_round = $this->round->findCurrentRound(time(), $data->type);
                                    if (!empty($curr_round)) {
                                        if (($curr_round->round_id == $data->round_id)) {
                                            $round_field = 'round_' . $curr_round->round_id . '_status';
                                            if (!empty($user_check->$round_field)) {
                                                if ($user_check->$round_field == 1) {
                                                    $exam_lock = 0;
                                                } else {
                                                    if ($curr_round->order == 1) {
                                                        $exam_lock = 0;
                                                    } else {
                                                        $exam_lock = 1;
                                                    }
                                                }
                                            } else {
                                                if ($curr_round->order == 1) {
                                                    $exam_lock = 0;
                                                } else {
                                                    $exam_lock = 1;
                                                }
                                            }
                                            if ($exam_lock == 1) {
                                                $res['success'] = false;
                                                $res['messages'] = "Không đủ diều kiện tham gia vòng thi này";
                                            }
                                            else {
                                                $topic = ContestTopic::find($data->topic_id);
                                                if(!empty($topic)){
                                                    $exam_data = new ExamData();
                                                    $exam_data->member_id = (int)$data->user_id;
                                                    $exam_data->round_id = (int)$data->round_id;
                                                    $exam_data->topic_id = (int)$data->topic_id;
                                                    $exam_data->clone_id = (int)$data->clone_id;
                                                    $exam_data->url = $data->url;
                                                    $exam_data->contest_env = (int)$data->contest_env;
                                                    $exam_data->status = 1;



                                                    $start_date = \DateTime::createFromFormat("Y-m-d H:i:s",$topic->start_date);
                                                    $start_date = $start_date->getTimestamp();
                                                    $end_date = \DateTime::createFromFormat("Y-m-d H:i:s",$topic->end_date);
                                                    $end_date = $end_date->getTimestamp();
                                                    if(time() > $start_date && time() < $end_date){
                                                        $total_repeat_time = $this->topic->totalRepeatTime($data->topic_id);
                                                        $total_exam_time = $this->examData->countRepeatTime($curr_round->round_id, $data->topic_id, $user_check->member_id);
                                                        if($total_repeat_time != 0){
                                                            if ($total_repeat_time > $total_exam_time) {
                                                                try{
                                                                    $exam_data->time_start = $time;
                                                                    $exam_data->repeat_time = (int)$total_exam_time + 1;
                                                                    $exam_data->save();
                                                                    $res['success'] = true;
                                                                    $res['data'] = [
                                                                        'start_time' => $time,
                                                                        'exam_id' => $exam_data->_id
                                                                    ];
                                                                }
                                                                catch(\Exception $e){
                                                                    $res['success']  = false;
                                                                    $res['messages'] = 'Có lỗi xảy ra';
                                                                }

                                                            } else {
                                                                $res['success']  = false;
                                                                $res['messages'] = 'Hết lượt thi';
                                                            }

                                                        }
                                                        else{
                                                            $exam_data->time_start = $time;
                                                            $exam_data->repeat_time = (int)$total_exam_time + 1;
                                                            $exam_data->save();
                                                            $res['success'] = true;
                                                            $res['data'] = [
                                                                'start_time' => $time,
                                                                'exam_id' => $exam_data->_id
                                                            ];
                                                        }

                                                    }
                                                    else{
                                                        $res['success'] = false;
                                                        $res['messages'] = "Tuần thi chưa mở hoặc đã kết thúc";
                                                    }
                                                }

                                            }
                                        } else {
                                            $res['success'] = false;
                                            $res['messages'] = 'Vòng thi không hợp lệ';
                                        }
                                    } else {
                                        $res['success'] = false;
                                        $res['messages'] = 'Vòng thi này chưa mở hoặc đã kết thúc';
                                    }

                                }
                                else {
                                    $res['success'] = false;
                                    $res['messages'] = 'Invalid topic';
                                }
                            } else {
                                $res['success'] = false;
                                $res['messages'] = 'Invalid round';
                            }
                        }
                    } else {
                        $res['success'] = false;
                        $res['messages'] = 'User chưa cập nhật thông tin cá nhân';
                    }
                } else {
                    $res['success'] = false;
                    $res['messages'] = 'Invalid user';
                }
            }else {
                $res['success'] = false;
                $res['messages'] = 'Invalid user';
            }
        }
        else {
            $res['success'] = false;
            $res['messages'] = 'Invalid token';
        }

        return response()->json($res);

    }

    public function end(Request $request){
        $res = [
            'success' => false,
            'data' => [],
            'messages' => ''
        ];
        $data = !empty((new ApiHash(env('SECRET_KEY'), env('SECRET_IV')))->decrypt($request->data)) ? json_decode((new ApiHash(env('SECRET_KEY'), env('SECRET_IV')))->decrypt($request->data)) : null;
        if (!empty($data->token)) {
// verify token eid
            $client = new Client();
            $headers = [
                'Authorization' => 'Bearer ' . env('BEARER_TOKEN'),
                'Accept' => 'application/json',
            ];
            $check = $client->request('GET', 'http://eid.vnedutech.vn/api/verify?token=' . $data->token, [
                'headers' => $headers
            ]);
            $check = $check->getBody()->getContents();
            $check = !empty($check) ? json_decode($check) : null;
// end verify
            if ($check && $check->success == true) {
                if ($check->data->user_id == $data->user_id) {
                    $user_check = UserContestInfo::where('member_id', (int)$data->user_id)->first();
                    if ($user_check) {
                        if(!empty($data->exam_id)){

                        }
                    }
                    else{
                    }
                }
                else{
                }
            }
            else{
            }
        }
        else{

        }
    }

    function getQuestionExam($user_id,$question_pack_id,$type){
        $result = null;
        $question_clone_arr = [];
        $user_clone_arr = [];
        if(!empty($question_pack_id)) {
            try {
                $question_exam = json_decode(file_get_contents('http://quiz2.vnedutech.vn/admin/toolquiz/contest/get-list-json/' . $question_pack_id));
                if (!empty($question_exam)) {
                    foreach ($question_exam as $key1 => $value1) {
                        $question_clone_arr[] = $value1->clone_id;
                    }
                }
            } catch (\Exception $e) {

            }
            if (!empty($user_id)) {
                if (!empty($type)) {
                    if ($type == 'test') {
                        $result = array_random($question_clone_arr);
                    } elseif ($type == 'real') {
                        $exam_data = ExamData::select('clone_id')->where('user_id', (int)$user_id)->get();

                        if ($exam_data->count() > 0) {
                            foreach ($exam_data as $key => $value) {
                                $user_clone_arr[] = $value->clone_id;
                            }
                        }
                        $remain_exam = array_diff($question_clone_arr, $user_clone_arr);
                        if (!empty($remain_exam)) {
                            $result = array_random($remain_exam);
                        }
                        else{
                            $result = array_random($question_clone_arr);
                        }
                    }
                }
            }

        }

        return $result;
    }

    function getTopicPointByCondition($exam_result, $point_method){

    }
}
