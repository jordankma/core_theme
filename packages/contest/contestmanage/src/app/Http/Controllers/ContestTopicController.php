<?php

namespace Contest\Contestmanage\App\Http\Controllers;

use Contest\Contestmanage\App\ContestEnvironment;
use Contest\Contestmanage\App\Http\Requests\TopicRequest;
use Contest\Contestmanage\App\Models\ContestTopic;
use Contest\Contestmanage\App\Models\TopicConfig;
use Contest\Contestmanage\App\Repositories\ContestRoundRepository;
use Contest\Contestmanage\App\Repositories\ContestSeasonRepository;
use Contest\Contestmanage\App\Repositories\ContestSettingRepository;
use Contest\Contestmanage\App\Repositories\ContestTargetRepository;
use Contest\Contestmanage\App\Repositories\ContestTopicRepository;
use Contest\Contestmanage\App\Repositories\TopicConfigRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Illuminate\Support\Facades\Schema;
use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator;

class ContestTopicController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );
    private $type = ['online' => 'Online', 'offline' => 'Offline'];

    public function __construct( ContestTopicRepository $topicRepository, ContestRoundRepository $roundRepository, TopicConfigRepository $topicConfigRepository, ContestSettingRepository $contestSettingRepository, ContestTargetRepository $targetRepository)
    {
        parent::__construct();
        $this->topic = $topicRepository;
        $this->env = new ContestEnvironment();
        $this->topicConfig = $topicConfigRepository;
        $this->setting = $contestSettingRepository;
        $this->target = $targetRepository;
        $this->round = $roundRepository;
    }

    public function add(TopicRequest $request)
    {
        $topic = new ContestTopic();
        $topic->display_name = $request->name;
        $topic->topic_name = str_slug($request->name);
        $topic->description = !empty($request->description)?base64_encode($request->description):null;
        $topic->rule_text = !empty($request->rules)?base64_encode($request->rules):null;
        $topic->end_notify = !empty($request->end_notify)?base64_encode($request->end_notify):'';
        $start_date = date_create_from_format('d-m-Y H:i', $request->start_date);
        $end_date = date_create_from_format('d-m-Y H:i', $request->end_date);
        $topic->start_date = $start_date;
        $topic->end_date = $end_date;
        $topic->topic_point_method = $request->topic_point_method;
        $topic->topic_exam_repeat_condition = $request->topic_exam_repeat_condition;
        $topic->topic_point_condition = $request->topic_point_condition;
        $topic->order = $request->number;
        $topic->round_id = $request->round_id;
        $topic->topic_type = $this->round->getRoundType((int)$request->round_id);
        $topic->question_pack_id = json_encode($request->question_pack_id);
        $topic->status = '1';
        $topic->exam_repeat_time = $request->exam_repeat_time;
        $topic->exam_repeat_time_wait = !empty($request->exam_repeat_time_wait)?$request->exam_repeat_time_wait:0;
        $topic->total_time_limit = !empty($request->total_time_limit)?$request->total_time_limit:0;
        $topic_round = [];

        if(!empty($request->topic_round)){
            foreach ($request->topic_round as $key => $item) {
                $topic_round[] = [
                    'round_name' => $item['round_name'],
                    'rule_text' => base64_encode($item['rule_text'])
                ];
            }
        }

        $topic->topic_round = json_encode($request->topic_round);
        try{
            $topic->save();
            if(!empty($request->environment)){
                $config_arr = [];
                foreach ( $request->environment as $key=>$value){
                    $config_arr[] = [
                        'environment' => $value,
                        'config_id' => $request->config_id[$key],
                        'topic_id' => $topic->topic_id,
                        'status' => '1'
                    ];
                }
                TopicConfig::insert($config_arr);
            }
            activity('contest_topic')
                ->performedOn($topic)
                ->withProperties($request->all())
                ->log('User: :causer.email - Add topic - name: :properties.name, topic_id: ' . $topic->topic_id);

            return redirect()->route('contest.contestmanage.contest_topic.manage')->with('success', trans('contest-contestmanage::language.messages.success.create'));
        }
        catch(\Exception $e) {
            echo "<pre>";print_r($e->getMessage());echo "</pre>";die;
//            return redirect()->route('contest.contestmanage.contest_topic.manage')->with('error', trans('contest-contestmanage::language.messages.error.create'));
        }

    }

    public function create()
    {
        $data_view = [
            'type' => $this->type,
            'environment' => $this->env->getEnvironment(),
            'topic_condition' => $this->setting->getSettingData('topic_condition'),
            'topic_point_method' => $this->setting->getSettingData('topic_point_method'),
            'target' => $this->target->getTargetList()
        ];
        return view('CONTEST-CONTESTMANAGE::modules.contestmanage.contest_topic.create', $data_view);
    }

    public function delete(Request $request)
    {
        $product_id = $request->input('product_id');
        $card_product = $this->contestRound->find($product_id);

        if (null != $card_product) {
            $this->contestRound->delete($product_id);

            activity('cardProduct')
                ->performedOn($card_product)
                ->withProperties($request->all())
                ->log('User: :causer.email - Delete cardProduct - product_id: :properties.product_id, name: ' . $card_product->product_name);

            return redirect()->route('contest.contestmanage.contest_topic.manage')->with('success', trans('contest-contestmanage::language.messages.success.delete'));
        } else {
            return redirect()->route('contest.contestmanage.contest_topic.manage')->with('error', trans('contest-contestmanage::language.messages.error.delete'));
        }
    }

    public function manage()
    {
        return view('CONTEST-CONTESTMANAGE::modules.contestmanage.contest_topic.manage');
    }

    public function show(Request $request)
    {
        $question_pack_name = [];
        $topic = $this->topic->find($request->topic_id);
        if(!empty($topic)){
            $start_date = date_create_from_format('Y-m-d H:i:s', $topic->start_date);
            $topic->start_date = $start_date->format('d-m-Y H:i');
            $end_date = date_create_from_format('Y-m-d H:i:s', $topic->end_date);
            $topic->end_date = $end_date->format('d-m-Y H:i');
            if(!empty($topic->question_pack_id)){
                $question_pack = json_decode($topic->question_pack_id, true);
                foreach ($question_pack as $key => $value){
                    $question = file_get_contents('http://quiz2.vnedutech.vn/admin/api/get_contest?question_pack_id='.$value);
                    if($question){
                        $question = json_decode($question);
                        $question_pack_name[$key] = $question->data->name;
                    }
                }
            }

        }
        $data = [
            'topic' => $topic,
            'type' => $this->type,
            'environment' => $this->env->getEnvironment(),
            'topic_config' => $this->topicConfig->findByTopic($request->topic_id),
            'question_pack_name' => $question_pack_name,
            'question_pack_id' => $question_pack,
            'topic_condition' => $this->setting->getSettingData('topic_condition'),
            'topic_point_method' => $this->setting->getSettingData('topic_point_method'),
            'target' => $this->target->getTargetList()
        ];

        return view('CONTEST-CONTESTMANAGE::modules.contestmanage.contest_topic.edit', $data);
    }

    public function update(TopicRequest $request)
    {
        $topic = $this->topic->find($request->topic_id);
        $topic->display_name = $request->name;
        $topic->topic_name = str_slug($request->name);
        $topic->description = !empty($request->description)?base64_encode($request->description):null;
        $topic->rule_text = !empty($request->rules)?base64_encode($request->rules):null;
        $topic->end_notify = !empty($request->end_notify)?base64_encode($request->end_notify):'';
        $start_date = date_create_from_format('d-m-Y H:i', $request->start_date);
        $end_date = date_create_from_format('d-m-Y H:i', $request->end_date);
        $topic->start_date = $start_date;
        $topic->end_date = $end_date;
        $topic->topic_point_method = $request->topic_point_method;
        $topic->topic_exam_repeat_condition = $request->topic_exam_repeat_condition;
        $topic->topic_point_condition = $request->topic_point_condition;
        $topic->order = $request->number;
        $topic->round_id = $request->round_id;
        $topic->topic_type = $this->round->getRoundType((int)$request->round_id);
        $topic->question_pack_id = json_encode($request->question_pack_id);
        $topic->status = '1';
        $topic->exam_repeat_time = $request->exam_repeat_time;
        $topic->exam_repeat_time_wait = !empty($request->exam_repeat_time_wait)?$request->exam_repeat_time_wait:0;
        $topic->total_time_limit = !empty($request->total_time_limit)?$request->total_time_limit:0;
        $topic_round = [];
        if(!empty($request->topic_round)){
            foreach ($request->topic_round as $key => $item) {
                $topic_round[] = [
                    'round_name' => $item['round_name'],
                    'rule_text' => base64_encode($item['rule_text'])
                ];
            }
        }
        $topic->topic_round = json_encode($topic_round);
        try{
            $topic->save();
            TopicConfig::where('topic_id', $request->topic_id)->delete();
            if(!empty($request->environment)){
                $config_arr = [];
                foreach ( $request->environment as $key=>$value){
                    $config_arr[] = [
                        'environment' => $value,
                        'config_id' => $request->config_id[$key],
                        'topic_id' => $topic->topic_id,
                        'status' => '1'
                    ];
                }
                TopicConfig::insert($config_arr);
            }
            activity('contest_topic')
                ->performedOn($topic)
                ->withProperties($request->all())
                ->log('User: :causer.email - Update topic - topic_id: :properties.topic_id, name: :properties.display_name');

            return redirect()->route('contest.contestmanage.contest_topic.manage')->with('success', trans('contest-contestmanage::language.messages.success.update'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', trans('contest-contestmanage::language.messages.error.update'));
        }
    }

    public function getModalDelete(Request $request)
    {
        $model = 'contest_topic';
        $tittle='Xác nhận xóa';
        $type=$this->contestRound->find($request->input('product_id'));
        $content='Bạn có chắc chắn muốn xóa loại: '.$type->product_name.'?';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $confirm_route = route('contest.contestmanage.contest_topic.delete', ['product_id' => $request->input('product_id')]);
                return view('contest-contestmanage::modules.cardmanage.includes.modal_confirmation', compact('error','tittle','content', 'model', 'confirm_route'));
            } catch (GroupNotFoundException $e) {
                return view('includes.modal_confirmation', compact('error', 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }

    public function log(Request $request)
    {
        $model = 'contest_topic';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $logs = Activity::where([
                    ['log_name', $model],
                    ['subject_id', $request->input('id')]
                ])->get();
                return view('includes.modal_table', compact('error', 'model', 'confirm_route', 'logs'));
            } catch (GroupNotFoundException $e) {
                return view('includes.modal_table', compact('error', 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }

    //Table Data to index page
    public function data()
    {
        return Datatables::of($this->topic->findAll())
            ->addColumn('actions', function ($topic) {
                $actions = '<a href=' . route('contest.contestmanage.contest_topic.log', ['type' => 'contest_topic', 'id' => $topic->topic_id]) . ' data-toggle="modal" data-target="#log"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="log topic"></i></a>
                <a href=' . route('contest.contestmanage.contest_topic.show', ['topic_id' => $topic->topic_id]) . '><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="update topic"></i></a>
                <a href=' . route('contest.contestmanage.contest_topic.confirm-delete', ['topic_id' => $topic->topic_id]) . ' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete topic"></i></a>';


                return $actions;
            })
            ->rawColumns(['actions'])
            ->make();
    }

    public function listQuestionPack(){
//        return '<div class="row"><div class="col-md-8"><p>Bộ đề thi thử Tìm hiểu biển đảo - đaknông</p></div> <a href="javascript:void(0)" c-data="125" d-data="Bộ đề thi thử Tìm hiểu biển đảo - đaknông" class="btn btn-success question_choose">Chọn</a> </div>';
        $html = view('CONTEST-CONTESTMANAGE::modules.contestmanage.includes.list_contest')->render();
        return response()->json($html);
    }

    public function getQuestionPackData(Request $request){
        if(!empty($request->question_pack_id)){
            $data = file_get_contents('http://quiz2.vnedutech.vn/admin/toolquiz/contest/get-json/'.$request->question_pack_id);
            $data_quest = file_get_contents($data);
            if(!empty($data_quest)){
               $data_quest = json_decode($data_quest,true);
               $res = [
                   'count' => count($data_quest['dethi']['list_round']),
                   'list_round' => $data_quest['dethi']['list_round']
               ];
               return response()->json($res);
            }
        }
    }

    public function getList(Request $request){
        if(!empty($request->round_id)){
            $result = ContestTopic::where('round_id', (int)$request->round_id)->get();
        }
        else{
            $result = ContestTopic::all();
        }
        return response()->json($result);
    }


}