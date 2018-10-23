<?php

namespace Contest\Contestmanage\App\Http\Controllers;

use Adtech\Application\Cms\Controllers\Controller as Controller;
use Contest\Contestmanage\App\ApiHash;
use Contest\Contestmanage\App\ContestEnvironment;
use Contest\Contestmanage\App\Http\Requests\SeasonRequest;
use Contest\Contestmanage\App\Models\ContestRound;
use Contest\Contestmanage\App\Models\ContestSeason;
use Contest\Contestmanage\App\Models\Counters;
use Contest\Contestmanage\App\Models\GroupExam;
use Contest\Contestmanage\App\Models\SeasonConfig;
use Contest\Contestmanage\App\Models\UserContestInfo;
use Contest\Contestmanage\App\Repositories\CandidateRepository;
use Contest\Contestmanage\App\Repositories\ContestConfigRepository;
use Contest\Contestmanage\App\Repositories\ContestSeasonRepository;
use Contest\Contestmanage\App\Repositories\GroupExamRepository;
use Contest\Contestmanage\App\Repositories\SeasonConfigRepository;
use Dhcd\Contest\App\Repositories\ContestRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Jenssegers\Mongodb\Schema\Blueprint;
use MongoDB\Client;
use Spatie\Activitylog\Models\Activity;
use Validator;
use Yajra\Datatables\Datatables;

class CandidateController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric' => "Phải là số"
    );

    public function __construct(ContestSeasonRepository $contestSeasonRepository, CandidateRepository $candidateRepository, GroupExamRepository $groupExamRepository)
    {
        parent::__construct();
        $this->candidate = $candidateRepository;
        $this->contestSeason = $contestSeasonRepository;
        $this->groupExam = $groupExamRepository;
    }

    public function add(Request $request)
    {
        $season = $this->contestSeason->getCurrentSeason();
       $user_info = new UserContestInfo();
       $hash = new ApiHash();
       $info = $hash->decrypt($request->data);
       if(!empty($info)){
           $info = json_decode($info,true);
           foreach ($info as $key=>$value){
               $user_info->$key = $value;
           }
           $user_info->season = !empty($season)?$season->season_id:1;
           try {
               $user_info->save();
               activity('user_contest_info')
                   ->performedOn($user_info)
                   ->withProperties($request->all())
                   ->log('User: :causer.email - Add user_contest_info - name: :properties.name, _id: ' . $user_info->_id);

               return redirect()->route('contest.contestmanage.candidate.manage')->with('success', trans('contest-contestmanage::language.messages.success.create'));
           }
           catch (\Exception $e) {
               return redirect()->route('contest.contestmanage.candidate.manage')->with('error', trans('contest-contestmanage::language.messages.error.create'));
           }
       }
    }


    public function register(Request $request){
        if(!empty($request->data)){
            $season = $this->contestSeason->getCurrentSeason();
            $user_info = new UserContestInfo();
            $user_info->nextID();
            $hash = new ApiHash();
            $info = $hash->decrypt($request->data);
            if(!empty($info)){
                parse_str($info, $data);
                $check_info = UserContestInfo::where('member_id', $data['member_id'])->first();
                if(!empty($check_info)){
                    $res = [
                        'status' => false,
                        'messages' => 'User đã đăng ký thông tin',
                        'data' => null
                    ];
                    return response()->json($res);
                }
                else{
                    foreach ($data as $key=>$value){
                        if($key == 'member_id'){
                            $user_info->$key = (int)$value;
                        }
                        elseif($key == 'u_name'){
                            $user_info->$key = strtolower($value);
                        }
                        elseif($key == 'birthday'){
                            try{
                                $user_info->$key = date_create_from_format('d-m-Y', $value)->date;
                            }
                            catch(\Exception $e){
                                $user_info->$key = $value;
                            }
                        }
                        elseif($key == 'object_id'){
                            $user_info->$key = (int)$value;
                        }
                        elseif($key == 'city_id'){
                            $user_info->$key = (int)$value;
                        }
                        elseif($key == 'district_id'){
                            $user_info->$key = (int)$value;
                        }
                        elseif($key == 'table_id'){
                            $user_info->$key = (int)$value;
                        }
                        elseif($key == 'status'){
                            $user_info->$key = (int)$value;
                        }
                        elseif($key == 'is_reg'){
                            $user_info->$key = (int)$value;
                        }
                        elseif($key == 'is_login'){
                            $user_info->$key = (int)$value;
                        }
                        else{
                            $user_info->$key = $value;
                        }
                    }
                    $user_info->season = !empty($season)?$season->season_id:1;
                    try {
                        $user_info->save();
                        $res = [
                            'status' => true,
                            'messages' => null,
                            'data' => [
                                'info_id' => $user_info->_id
                            ]
                        ];
                        return response()->json($res);
                    }
                    catch (\Exception $e) {
                        $res = [
                            'status' => false,
                            'messages' => $e->getMessage(),
                            'data' => null
                        ];
                        return response()->json($res);
                    }
                }
            }
            else{
                $res = [
                    'status' => false,
                    'messages' => 'thông tin không hợp lệ',
                    'data' => null
                ];
                return response()->json($res);
            }
        }
        else{
            $res = [
                'status' => false,
                'messages' => 'data null',
                'data' => null
            ];
            return response()->json($res);
        }
    }


    public function create()
    {
        $data_view = [
            'environment' => $this->env->getEnvironment()
        ];
        return view('CONTEST-CONTESTMANAGE::modules.contestmanage.candidate.create', $data_view);
    }

    public function delete(Request $request)
    {
        $product_id = $request->input('product_id');
        $card_product = $this->contestSeason->find($product_id);

        if (null != $card_product) {
            $this->contestSeason->delete($product_id);

            activity('cardProduct')
                ->performedOn($card_product)
                ->withProperties($request->all())
                ->log('User: :causer.email - Delete cardProduct - product_id: :properties.product_id, name: ' . $card_product->product_name);

            return redirect()->route('contest.contestmanage.candidate.manage')->with('success', trans('contest-contestmanage::language.messages.success.delete'));
        } else {
            return redirect()->route('contest.contestmanage.candidate.manage')->with('error', trans('contest-contestmanage::language.messages.error.delete'));
        }
    }

    public function manage()
    {
        $candidates = UserContestInfo::paginate(10);
        return view('CONTEST-CONTESTMANAGE::modules.contestmanage.candidate.manage', ['candidates' => $candidates]);
    }

    public function show(Request $request)
    {
        $season = $this->contestSeason->find($request->season_id);
        $data = [
            'season' => $season,
            'environment' => $this->env->getEnvironment(),
            'season_config' => $this->seasonConfig->findBySeason($request->season_id)
        ];

        return view('CONTEST-CONTESTMANAGE::modules.contestmanage.candidate.edit', $data);
    }

    public function update(SeasonRequest $request)
    {
        $season = $this->contestSeason->find($request->season_id);
        $season->name = $request->name;
        $season->alias = str_slug($request->name);
        $season->description = $request->description;
        $season->rule = $request->rules;
        $season->before_start_notify = $request->before_start_notify;
        $season->after_end_notify = $request->after_end_notify;
        $start_date = date_create_from_format('d-m-Y H:i', $request->start_date);
        $end_date = date_create_from_format('d-m-Y H:i', $request->end_date);
        $season->start_date = $start_date;
        $season->end_date = $end_date;
        $season->number = $request->number;
        try {
            $season->update();
            SeasonConfig::where('season_id', $request->season_id)->delete();
            if (!empty($request->environment)) {
                $config_arr = [];
                foreach ($request->environment as $key => $value) {
                    $config_arr[] = [
                        'environment' => $value,
                        'config_id' => $request->config_id[$key],
                        'season_id' => $season->season_id,
                        'status' => '1'
                    ];
                }
                SeasonConfig::insert($config_arr);
            }

            activity('candidate')
                ->performedOn($season)
                ->withProperties($request->all())
                ->log('User: :causer.email - Update season - product_id: :properties.season_id, name: :properties.name');

            return redirect()->route('contest.contestmanage.candidate.manage')->with('success', trans('contest-contestmanage::language.messages.success.update'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
//            return redirect()->back()->with('error', trans('contest-contestmanage::language.messages.error.update'));
        }
    }

    public function getModalDelete(Request $request)
    {
        $model = 'cardProduct';
        $tittle = 'Xác nhận xóa';
        $type = $this->contestSeason->find($request->input('product_id'));
        $content = 'Bạn có chắc chắn muốn xóa loại: ' . $type->product_name . '?';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $confirm_route = route('contest.contestmanage.candidate.delete', ['product_id' => $request->input('product_id')]);
                return view('contest-contestmanage::modules.cardmanage.includes.modal_confirmation', compact('error', 'tittle', 'content', 'model', 'confirm_route'));
            } catch (GroupNotFoundException $e) {
                return view('includes.modal_confirmation', compact('error', 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }

    public function log(Request $request)
    {
        $model = 'candidate';
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
    public function data(Request $request)
    {
        $start = (int)$request->start;
        $length = (int)$request->length != 0?(int)$request->length:10;
        return Datatables::of($this->candidate->getData($start, $length))
            ->setTotalRecords($this->candidate->countAll())
            ->addColumn('actions', function ($candidate) {
                $actions = '<a href="javascript:void(0)" class="choose" c-data="'.$candidate->member_id.'"><i class="livicon" data-name="plus" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="choose"></i></a>';

//                if ($season->status == '0') {
//                    $actions .= '<a href="' . route('contest.contestmanage.candidate.change', ['season_id' => $season->season_id]) . '" ><i class="livicon" data-name="circle" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="active season"></i></a>';
//                }
//                $actions .= '<a href=' . route('contest.contestmanage.candidate.log', ['type' => 'candidate', 'id' => $season->season_id]) . ' data-toggle="modal" data-target="#log"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="log season"></i></a>
//                <a href=' . route('contest.contestmanage.candidate.show', ['season_id' => $season->season_id]) . '><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="update season"></i></a>
//                <a href=' . route('contest.contestmanage.candidate.confirm-delete', ['season_id' => $season->season_id]) . ' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete season"></i></a>';

                return $actions;
            })
            ->rawColumns(['actions'])
            ->make();
    }

    public function getConfig(Request $request)
    {
        $conf_list = $this->seasonConfig->findBySeason($request->season_id);
        $config_list = [];
        if (!empty($conf_list)) {
            foreach ($conf_list as $key => $item) {
                $config = $this->config->find($item->config_id);
                if (!empty($config)) {
                    $config_list[] = [
                        'environment' => $config->environment,
                        'config' => json_decode($config->config)
                    ];
                }
            }
        }
        return response()->json($config_list);
    }

    public function change(Request $request)
    {
        $curr_season = $this->contestSeason->getCurrentSeason();
        $name = 'users_exam_info_' . $curr_season->number;
        try {
            $db = config('database.connections.mongodb.database');
            DB::connection('mongodb')->getMongoClient()->admin->command([
                'renameCollection' => "{$db}.users_exam_info",
                'to' => "{$db}." . $name,
            ]);
            Schema::connection('mongodb')->create('users_exam_info', function (Blueprint $table) {
            });
            $curr_season->db_name = $name;
            $curr_season->status = '0';
            $curr_season->update();
            $new_season = $this->contestSeason->find($request->season_id);
            $new_season->status = '1';
            $new_season->db_name = 'users_exam_info';
            $new_season->update();
            return redirect()->route('contest.contestmanage.candidate.manage')->with('success', trans('contest-contestmanage::language.messages.success.update'));
        } catch (\Exception $e) {
            echo "<pre>";
            print_r($e->getMessage());
            echo "</pre>";
            die;
        }


    }

    public function getList(Request $request){
        $start = (int)$request->start;
        $length = (int)$request->length;
        if(!empty($request->group_exam_id)){
            $group_exam_id = $request->group_exam_id;
            $group_exam = $this->groupExam->find($group_exam_id);
            if(!empty($group_exam->list_candidate)){
               $list_candidate = json_decode($group_exam->list_candidate, true);
                return Datatables::of($this->candidate->getListData($list_candidate,$start, $length))
                    ->setTotalRecords($this->candidate->countData($list_candidate))
                    ->addColumn('actions', function ($candidate) {
                        $actions = '<a href="javascript:void(0)" class="choose" c-data="'.$candidate->member_id.'"><i class="livicon" data-name="plus" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="choose"></i></a>';
                        return $actions;
                    })
                    ->rawColumns(['actions'])
                    ->make();
            }
            else{
               $round = ContestRound::find($group_exam->round_id);
               if(!empty($round)){
                   $other_group = GroupExam::where('round_id',$round->round_id)->get();
                   if(!empty($other_group)){
                       $list_candidate = [];
                       foreach ($other_group as $key=>$value){
                           if($value->group_exam_id != $group_exam_id){
                               $list = json_decode($value->list_candidate, true);
                               foreach ($list as $key2=>$value2){
                                   $list_candidate[] = $value2;
                               }
                           }
                       }
                       return Datatables::of($this->candidate->getListData($list_candidate,$start, $length))
                           ->setTotalRecords($this->candidate->countData($list_candidate))
                           ->addColumn('actions', function ($candidate) {
                               $actions = '<a href="javascript:void(0)" class="choose" c-data="'.$candidate->member_id.'"><i class="livicon" data-name="plus" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="choose"></i></a>';
                               return $actions;
                           })
                           ->rawColumns(['actions'])
                           ->make();
                   }
                   else{
                       return Datatables::of($this->candidate->getData($start, $length))
                           ->setTotalRecords($this->candidate->countAll())
                           ->addColumn('actions', function ($candidate) {
                               $actions = '<a href="javascript:void(0)" class="choose" c-data="'.$candidate->member_id.'"><i class="livicon" data-name="plus" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="choose"></i></a>';
                               return $actions;
                           })
                           ->rawColumns(['actions'])
                           ->make();
                   }
               }
            }
        }
    }

    public function syncRegister(Request $request){
        if(!empty($request->data)){
            $data = file_get_contents('http://timhieubiendao.daknong.vn/admin/api/member/get_member_data?data='.$request->data);
            if(!empty($data)){
                $data = json_decode($data,true);
                $season = $this->contestSeason->getCurrentSeason();
                $arr = [];
                $count = Counters::find('candidate_id');
                $last_id = $count->seq;
                foreach ($data as $key => $value){
                    $last_id += 1;
                    $arr[$key] = [];
                    $arr[$key]['_id'] = $last_id;
                    $arr[$key]['season'] = !empty($season)?$season->season_id:1;
                    foreach ($value as $key1 => $value1) {
                        $arr[$key][$key1] = $value1;
                    }
                }
                $collection = (new Client('mongodb://123.30.174.148'))->selectDatabase('daknong')->selectCollection('users_exam_info');
                $mongo_result = $collection->insertMany($arr);
                if(!empty($mongo_result)){
                    $count->seq = (double)($last_id);
                    $count->update();
                    file_get_contents('http://timhieubiendao.daknong.vn/admin/api/member/update_sync?data='.$request->data);
                    echo "<pre>";print_r($mongo_result->getInsertedIds());echo "</pre>";
                }
            }
        }
    }
}