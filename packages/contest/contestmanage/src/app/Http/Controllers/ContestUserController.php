<?php

namespace Contest\Contestmanage\App\Http\Controllers;

use Adtech\Application\Cms\Controllers\Controller as Controller;
use Contest\Contestmanage\App\ApiHash;
use Contest\Contestmanage\App\Models\ContestResult;
use Contest\Contestmanage\App\Models\ContestRound;
use Contest\Contestmanage\App\Models\ContestTopic;
use Contest\Contestmanage\App\Models\UserContestInfo;
use Contest\Contestmanage\App\Repositories\ContestRoundRepository;
use Contest\Contestmanage\App\Repositories\ContestTargetRepository;
use Contest\Contestmanage\App\Repositories\ContestTopicRepository;
use Contest\Contestmanage\App\Repositories\FormLoadRepository;
use Contest\Exam\App\Models\ExamData;
use Illuminate\Http\Request;
use MongoDB\Client;
use Validator;
use Yajra\Datatables\Datatables;

class ContestUserController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric' => "Phải là số"
    );

    public function __construct(ContestTargetRepository $targetRepository, FormLoadRepository $formLoadRepository, ContestRoundRepository $roundRepository, ContestTopicRepository $topicRepository)
    {
        parent::__construct();
        $this->target = $targetRepository;
        $this->form_load = $formLoadRepository;
        $this->round = $roundRepository;
        $this->topic = $topicRepository;
    }


    public function manage1()
    {
        $filter_data = $this->form_load->getFilterField('backend','contest_user');
        $result_data = $this->form_load->getResultField('backend','contest_user');

        $data_view = [
            'filter_data' => $filter_data,
            'result_data' => $result_data,
        ];
        return view('CONTEST-CONTESTMANAGE::modules.contestmanage.contest_user.manage',$data_view);
    }

    public function manage(Request $request)
    {
        $round_list = $this->round->getListPluck();
        $topic_list = $this->topic->getListPluck();
        $filter_data = $this->form_load->getFilterField('backend','contest_user');
        $result_data = $this->form_load->getResultField('backend','contest_user');
        $user_info = [];
        if(!empty($request->u_name)){
            $u_name = explode(',',$request->u_name);
            foreach ($u_name as $u){
                $user = UserContestInfo::where('u_name',$u)->first();
                $user_info[] = $user;
            }
        }

        $data_view = [
            'filter_data' => $filter_data,
            'result_data' => $result_data,
            'user_info' => $user_info,
            'round_list' => $round_list,
            'topic_list' => $topic_list
        ];
        return view('CONTEST-CONTESTMANAGE::modules.contestmanage.contest_user.manage',$data_view);
    }

    public function show(Request $request)
    {
        $season = $this->contestSeason->find($request->season_id);
        $data = [
            'season' => $season,
            'environment' => $this->env->getEnvironment(),
            'season_config' => $this->seasonConfig->findBySeason($request->season_id)
        ];

        return view('CONTEST-CONTESTMANAGE::modules.contestmanage.contest_user.edit', $data);
    }

    public function resetExam(Request $request){
        $res = [
            'success' => false,
        ];
        if(!empty($request->member_id) && !empty($request->round_id) && !empty($request->topic_id) && !empty($request->repeat_time)){
            $contest_id = (int)config('app.contest_id');
            $member_id = (int)$request->member_id;
            $round_id = (int)$request->round_id;
            $topic_id = (int)$request->topic_id;
            $repeat_time = (int)$request->repeat_time;
            $config_host = config('database.connections.mongodb_nodejs.host');
            if(is_array($config_host)){
                $host = $config_host[0];
            }
            else{
                $host = $config_host;
            }
            $port = config('database.connections.mongodb_nodejs.port');
            $user = config('database.connections.mongodb_nodejs.username');
            $pass = config('database.connections.mongodb_nodejs.password');
            $db = config('database.connections.mongodb_nodejs.database');
            try {
                $collection1 = (new Client('mongodb://' . $user . ':' . $pass . '@' . $host . ':' . $port . '/' . $db))->selectDatabase($db)->selectCollection('tralois');
                $collection1->deleteMany(['user_id' => $member_id,'contest_id' => $contest_id, 'round_id' => $round_id, 'topic_id' => $topic_id, 'bode_stt' => $repeat_time]);
                $collection2 = (new Client('mongodb://' . $user . ':' . $pass . '@' . $host . ':' . $port . '/' . $db))->selectDatabase($db)->selectCollection('cauhois');
                $collection2->deleteMany(['user_id' => $member_id,'contest_id' => $contest_id, 'round_id' => $round_id, 'topic_id' => $topic_id, 'bode_stt' => $repeat_time]);
                $collection3 = (new Client('mongodb://' . $user . ':' . $pass . '@' . $host . ':' . $port . '/' . $db))->selectDatabase($db)->selectCollection('bodes');
                $collection3->deleteMany(['user_id' => $member_id,'contest_id' => $contest_id, 'round_id' => $round_id, 'topic_id' => $topic_id, 'bode_stt' => $repeat_time]);
                $collection4 = (new Client('mongodb://' . $user . ':' . $pass . '@' . $host . ':' . $port . '/' . $db))->selectDatabase($db)->selectCollection('results');
                $collection4->deleteMany(['member_id' => $member_id,'contest_id' => $contest_id, 'round_id' => $round_id, 'topic_id' => $topic_id, 'repeat_time' => $repeat_time]);
                ContestResult::where(['member_id' =>$member_id, 'round_id' => $round_id, 'topic_id' => $topic_id, 'repeat_time' => $repeat_time])->delete();
//                ExamData::where(['member_id' =>$member_id, 'round_id' => $round_id, 'topic_id' => $topic_id, 'repeat_time' => $repeat_time])->delete();
                $res = [
                    'success' => true,
                ];
            }
            catch (\Exception $e){
                echo '<pre>';print_r($e->getMessage());echo '</pre>';die;
            }
        }

        return response()->json($res);
    }

    public function data(Request $request)
    {
        $params = [];
        if(!empty($request->province_id) && $request->province_id != 0){
            $params['province_id'] = (int)$request->province_id;
        }
        if(!empty($request->district_id) && $request->district_id != 0){
            $params['district_id'] = (int)$request->district_id;
        }
        if(!empty($request->school_id) && $request->school_id != 0){
            $params['school_id'] = (int)$request->school_id;
        }
        if(!empty($request->target)){
            $params['target'] = $request->target;
        }
        if(!empty($request->class_group)){
            $params['class_group'] = (int)$request->class_group;
        }
        if(!empty($request->class_id) && $request->class_id != 0){
            $params['class_id'] = (int)$request->class_id;
        }
        if(!empty($request->u_name)){
            $params['u_name'] = $request->u_name;
        }
        if(!empty($request->phone)){
            $params['phone'] = (int)$request->phone;
        }
        if(!empty($request->email)){
            $params['email'] = $request->email;
        }

        $start = (int)$request->start;
        $length = !empty($request->length)?(int)$request->length:10;
        $query = UserContestInfo::with('examResult')->where($params);
        $total = $query->count();
        $query = $query->skip($start)->take($length)->get();
        $request->merge(['start' => 0]);
        return Datatables::of($query)->setTotalRecords($total)
            ->addColumn('actions', function ($user) {
            $actions = '<a href=' . route('contest.contestmanage.contest_user.log', ['type' => 'contest_user', 'id' => $user->member_id]) . ' data-toggle="modal" data-target="#log"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="log"></i></a>
                        <a href="javascript:void(0)" class="reset_exam" c-data="'.$user->member_id.'"><i class="livicon" data-name="refresh" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="reset lượt thi"></i></a>
                       <a href=' . route('contest.contestmanage.contest_user.show', ['round_id' => $user->member_id]) . '><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="xem chi tiết"></i></a>';
            return $actions;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }


}