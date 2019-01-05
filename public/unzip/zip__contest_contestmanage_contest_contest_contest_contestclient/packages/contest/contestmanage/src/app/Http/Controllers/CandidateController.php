<?php

namespace Contest\Contestmanage\App\Http\Controllers;

use Adtech\Application\Cms\Controllers\Controller as Controller;
use Contest\Contestmanage\App\ApiHash;
use Contest\Contestmanage\App\ContestEnvironment;
use Contest\Contestmanage\App\ExportFromCollection;
use Contest\Contestmanage\App\Exports;
use Contest\Contestmanage\App\Http\Requests\SeasonRequest;
use Contest\Contestmanage\App\Models\ContestResult;
use Contest\Contestmanage\App\Models\ContestRound;
use Contest\Contestmanage\App\Models\ContestSeason;
use Contest\Contestmanage\App\Models\ContestTarget;
use Contest\Contestmanage\App\Models\ContestTopic;
use Contest\Contestmanage\App\Models\Counters;
use Contest\Contestmanage\App\Models\FormLoad;
use Contest\Contestmanage\App\Models\GroupExam;
use Contest\Contestmanage\App\Models\SeasonConfig;
use Contest\Contestmanage\App\Models\UserContestInfo;
use Contest\Contestmanage\App\Repositories\CandidateRepository;
use Contest\Contestmanage\App\Repositories\ContestConfigRepository;
use Contest\Contestmanage\App\Repositories\ContestSeasonRepository;
use Contest\Contestmanage\App\Repositories\ContestTargetRepository;
use Contest\Contestmanage\App\Repositories\GroupExamRepository;
use Contest\Contestmanage\App\Repositories\SeasonConfigRepository;
use Dhcd\Contest\App\Repositories\ContestRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Jenssegers\Mongodb\Schema\Blueprint;
use MongoDB\Client;
use Spatie\Activitylog\Models\Activity;
use Tebru\Gson\Element\JsonElement;
use Tebru\Gson\Gson;
use Tebru\Gson\Internal\TypeAdapter\JsonElementTypeAdapter;
use Validator;
use Yajra\Datatables\Datatables;

class CandidateController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric' => "Phải là số"
    );

    public function __construct(ContestSeasonRepository $contestSeasonRepository, CandidateRepository $candidateRepository, GroupExamRepository $groupExamRepository, ContestTargetRepository $targetRepository)
    {
        parent::__construct();
        $this->candidate = $candidateRepository;
        $this->contestSeason = $contestSeasonRepository;
        $this->groupExam = $groupExamRepository;
        $this->target = $targetRepository;
        $this->store_path = 'export/excel/';
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
               if($key != "created_at" && $key != "updated_at"){
                   $user_info->$key = $value;
               }
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
        $season = $this->contestSeason->getCurrentSeason();

//        $hash = new ApiHash(env('SECRET_KEY'),env('SECRET_IV'));
        $hash = new ApiHash('t+m:*meo6h}b?{~','*[Py49<>n@-VYr1');
        if(!empty($request->data)){
            $user_info = new UserContestInfo();
            $user_info->nextID();
            $info = $hash->decrypt(str_replace('\n','',$request->data));
            if(!empty($info)){
                $data = json_decode($info, true);
                if(!empty($data['member_id'])){
                    if(UserContestInfo::count() >0){
                        $check_info = UserContestInfo::where('member_id', (int)$data['member_id'])->first();
                    }

                    if(!empty($check_info)){
                        $res = [
                            'success' => false,
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
                            elseif($key == 'province_id'){
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
                                'success' => true,
                                'messages' => null,
                                'data' => array()
                            ];
                            $field = ContestTarget::first();
                            if(!empty($field->general)){
                                foreach ($field->general as $key3 => $value3) {

                                }
                            }
                            return response()->json($res);
                        }
                        catch (\Exception $e) {
                            $res = [
                                'success' => false,
                                'messages' => $e->getMessage(),
                                'data' => null
                            ];
                            return response()->json($res);
                        }
                    }
                }
                else{
                    $res = [
                        'success' => false,
                        'messages' => 'member_id not found',
                        'data' => null
                    ];
                    return response()->json($res);
                }

            }
            else{
                $res = [
                    'success' => false,
                    'messages' => 'thông tin không hợp lệ',
                    'data' => null
                ];
                return response()->json($res);
            }
        }
        elseif(!empty($request->getContent())){
            $data = $request->getContent();
            $user_info = new UserContestInfo();
            $user_info->nextID();
//            $info = $hash->decrypt($data);
            $info = $hash->decrypt(str_replace('\n','',$data));

            if(!empty($info)){
//                parse_str($info, $data);
                $data = json_decode($info, true);
                if(!empty($data['member_id'])){
                    if(UserContestInfo::count() >0){
                        $check_info = UserContestInfo::where('member_id', (int)$data['member_id'])->first();
                    }

                    if(!empty($check_info)){
                        $res = [
                            'success' => false,
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
                            elseif($key == 'province_id'){
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
                                'success' => true,
                                'messages' => null,
                                'data' => [
                                    'info_id' => $user_info->_id
                                ]
                            ];
                            return response()->json($res);
                        }
                        catch (\Exception $e) {
                            $res = [
                                'success' => false,
                                'messages' => $e->getMessage(),
                                'data' => null
                            ];
                            return response()->json($res);
                        }
                    }
                }
                else{
                    $res = [
                        'success' => false,
                        'messages' => 'member_id not found',
                        'data' => null
                    ];
                    return response()->json($res);
                }

            }
            else{
                $res = [
                    'success' => false,
                    'messages' => 'thông tin không hợp lệ',
                    'data' => null
                ];
                return response()->json($res);
            }
        }
        else{
            $res = [
                'success' => false,
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
//        $object = ContestResult::first();
//       $gson = Gson::builder();
//       $gson->registerType(JsonElement::class, new JsonElementTypeAdapter())->build()->toJson($object);
//       echo '<pre>';print_r($gson);echo '</pre>';die;

        $provinces = $this->target->getProvince();
        $districts = $this->target->getDistrict();
        $district_data = [];
        $province_data = [];
        $district_api = '';
        $province_api = '';
        if(!empty($provinces)){
            if($provinces['type'] == 'data'){
                foreach ($provinces['data_view'] as $key2 => $value2) {
                    $province_data[$value2['key']] = $value2['value'];
                }
            }
            elseif($provinces['type'] == 'api'){
                if(empty($provinces['parent_field'])){
                    $province_data = file_get_contents($provinces['api']);
                }
                else{
                    $province_api = $provinces['api'];
                }
            }
        }
        if(!empty($districts)){
            if($districts['type'] == 'data'){
                foreach ($districts['data_view'] as $key2 => $value2) {
                    $district_data[$value2['key']] = $value2['value'];
                }
            }
            elseif($districts['type'] == 'api'){
                if(empty($districts['parent_field'])){
                    $district_data = file_get_contents($districts['api']);
                }
                else{
                    $district_api = $districts['api'];
                }
            }
        }
        $data_view = [
            'table' => [
                1 => 'Bảng A',
                2 => 'Bảng B'
            ],
            'city' => $province_data,
            'district' => $district_data,
            'district_api' => $district_api,
            'province_api' => $province_api,
            'round' => ContestRound::where('round_type','real')->pluck('display_name','round_id'),
            'topic' => ContestTopic::where('topic_type','real')->pluck('display_name','topic_id'),
        ];
        return view('CONTEST-CONTESTMANAGE::modules.contestmanage.candidate.manage',$data_view);
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

    public function update(Request $request)
    {
        $res = [
            'success' => false,
            'messages' => null,
            'data' => null
        ];
        if(!empty($request->data)){
            $hash = new ApiHash();
            $info = $hash->decrypt($request->data);
            if(!empty($info)){
                parse_str($info, $data);
                if(UserContestInfo::count() >0){
                    $user_info = UserContestInfo::where('member_id', $data['member_id'])->first();
                    if(!empty($user_info)){
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
                            elseif($key == 'province_id'){
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
                                'success' => true,
                                'messages' => null,
                                'data' => [
                                    'info_id' => $user_info->_id
                                ]
                            ];
                            return response()->json($res);
                        }
                        catch (\Exception $e) {
                            $res = [
                                'success' => false,
                                'messages' => $e->getMessage(),
                                'data' => null
                            ];
                            return response()->json($res);
                        }
                    }
                    else{
                        $res['messages'] = 'User không tồn tại';
                    }
                }
                else{
                    $res['messages'] = 'User không tồn tại';
                }
            }
            else{
                $res['messages'] = 'thông tin không hợp lệ';
            }
        }
        else{
            $res['messages'] = 'data null';
        }
        return response()->json($res);
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
        $params = [];
        if(!empty($request->province_id)){
            $params['province_id'] = (int)$request->province_id;
        }
        if(!empty($request->district_id)){
            $params['district_id'] = (int)$request->district_id;
        }
         if(!empty($request->school_id)){
            $params['school_id'] = (int)$request->school_id;
        }
         if(!empty($request->table_id)){
            $params['table_id'] = (int)$request->table_id;
        }
         if(!empty($request->u_name)){
            $params['u_name'] = $request->u_name;
        }
        if(!empty($request->user_id)){
            $params['member_id'] = $request->user_id;
        }
        if(!empty($request->email)){
            $params['email'] = $request->email;
        }

        $start = (int)$request->start;
        $length = !empty($request->length)?(int)$request->length:10;
        $query = UserContestInfo::query()->where($params);
        if(!empty($request->name)){
            $query = UserContestInfo::query()->where($params)->where('name','like','%'.$request->name.'%');
        }

        $total = $query->count();
        $query = $query->skip($start)->take($length)->get();
        $request->merge(['start' => 0]);
        return Datatables::of($query)->setTotalRecords($total)->make(true);
    }

    public function dataResult(Request $request)
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

        $result = ContestResult::with('candidate')->whereHas('candidate', function ($query) use($member_cond, $name){
            $query->where($member_cond);
            if(!empty($name)){
                $query->where('name','like','%'.$name.'%');
            }
        })->where($result_cond)->orderBy('total_point', 'desc')->orderBy('used_time', 'asc');
        $total = $result->count();
        $start = (int)$request->start;
        $length = !empty($request->length)?(int)$request->length:10;
        $result = $result->skip($start)->take($length)->get();
        $request->merge(['start' => 0]);
        return Datatables::of($result)->setTotalRecords($total)->make(true);
    }

    public function dataStatistics(Request $request)
    {
        $params = [];
        if(!empty($request->province_id)){
            $params['province_id'] = (int)$request->province_id;
        }
        if(!empty($request->district_id)){
            $params['district_id'] = (int)$request->district_id;
        }
        if(!empty($request->school_id)){
            $params['school_id'] = (int)$request->school_id;
        }
        if(!empty($request->table_id)){
            $params['table_id'] = (int)$request->table_id;
        }
        if(!empty($request->topic_id)){
            $params['topic_id'] = (int)$request->topic_id;
        }
        if(!empty($request->round_id)){
            $params['round_id'] = (int)$request->round_id;
        }

        $start = (int)$request->start;
        $length = !empty($request->length)?(int)$request->length:10;

            $query = ContestResult::query()->where($params);
            $total = $query->count();
            $query = $query->orderBy('point_real','desc')->skip($start)->take($length)->get();
        $request->merge(['start' => 0]);
        return Datatables::of($query)->setTotalRecords($total)->make(true);
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
                $host = config('database.connections.mongodb.host');
                $port = config('database.connections.mongodb.port');
                $user = config('database.connections.mongodb.username');
                $pass = config('database.connections.mongodb.password');
                $db = config('database.connections.mongodb.database');
                $collection = (new Client('mongodb://'.$user.':'.$pass.'@'.$host.':'.$port.'/'.$db))->selectDatabase($db)->selectCollection('users_exam_info');
                $mongo_result = $collection->insertMany($arr);
//                $collection = (new Client('mongodb://123.30.174.148'))->selectDatabase('daknong')->selectCollection('users_exam_info');
//                $mongo_result = $collection->insertMany($arr);
                if(!empty($mongo_result)){
                    $count->seq = (double)($last_id);
                    $count->update();
                    file_get_contents('http://timhieubiendao.daknong.vn/admin/api/member/update_sync?data='.$request->data);
                    echo "<pre>";print_r($mongo_result->getInsertedIds());echo "</pre>";
                }
            }
        }
    }

    public function exportExcel(Request $request)
    {
        if(!empty($request->module)){
            $store_path = $this->store_path.'/'.$request->module;
            if($request->module == 'result'){

                try {
                    $current_date = date('Ymd', time());
                    $req = $request->all();
                    $name = 'ds_ketquathi_' . $current_date. '.xlsx';

                    if ($this->storeExcel( $req, $name, $request->module)) {
                        shell_exec('cd ../ && zip -r storage/app/' . $store_path . $name . ' storage/app/' . $store_path . $name);
                        return Storage::download($store_path . $name, $name);
                    }
                } catch (\Exception $e) {
                    echo "<pre>";
                    print_r($e->getMessage());
                    echo "</pre>";
                    die;
                }
            }
            elseif($request->module == 'candidate'){
                try {
                    $current_date = date('Ymd', time());
                    $req = $request->all();
                    $name = 'ds_thisinh_' . $current_date. '.xlsx';

                    if ($this->storeExcel( $req, $name, $request->module)) {
                        shell_exec('cd ../ && zip -r storage/app/' . $store_path . $name . ' storage/app/' . $store_path . $name);
                        return Storage::download($store_path . $name, $name);
                    }
                } catch (\Exception $e) {
                    echo "<pre>";
                    print_r($e->getMessage());
                    echo "</pre>";
                    die;
                }
            }
        }
        else{

        }
    }

    public function storeExcel($data, $name, $module)
    {
        ob_start();
        $store_path = $this->store_path.'/'.$module;
        if($module =='candidate'){
//            $export = new Exports( $data, 'candidate');
            $export = new ExportFromCollection( $data, 'candidate');
        }
        else{
            $export = new ExportFromCollection( $data, 'result');
        }
        ob_end_clean();
        return $export->store($store_path . $name);
    }

    public function result()
    {
        $provinces = $this->target->getProvince();
        $districts = $this->target->getDistrict();
        $district_data = [];
        $province_data = [];
        $district_api = '';
        $province_api = '';
        if(!empty($provinces)){
            if($provinces['type'] == 'data'){
                foreach ($provinces['data_view'] as $key2 => $value2) {
                    $province_data[$value2['key']] = $value2['value'];
                }
            }
            elseif($provinces['type'] == 'api'){
                if(empty($provinces['parent_field'])){
                    $province_data = file_get_contents($provinces['api']);
                }
                else{
                    $province_api = $provinces['api'];
                }
            }
        }
        if(!empty($districts)){
            if($districts['type'] == 'data'){
                foreach ($districts['data_view'] as $key2 => $value2) {
                    $district_data[$value2['key']] = $value2['value'];
                }
            }
            elseif($districts['type'] == 'api'){
                if(empty($districts['parent_field'])){
                    $district_data = file_get_contents($districts['api']);
                }
                else{
                    $district_api = $districts['api'];
                }
            }
        }
        $data_view = [
            'table' => [
                1 => 'Bảng A',
                2 => 'Bảng B'
            ],
            'city' => $province_data,
            'district' => $district_data,
            'district_api' => $district_api,
            'province_api' => $province_api,
            'round' => ContestRound::where('round_type','real')->pluck('display_name','round_id'),
            'topic' => ContestTopic::where('topic_type','real')->pluck('display_name','topic_id'),
        ];
        return view('CONTEST-CONTESTMANAGE::modules.contestmanage.candidate.result',$data_view);
    }
//SET thi lại cho user
    public function setExam()
    {
        $data_city = [];
        $data_district = [];
        $citys= $this->target->getCity();
        if(!empty($citys)){
            foreach ($citys as $key => $city) {
                $data_city[$city['id']] = $city['name'];
            }
        }
        try{
            $districts = json_decode(file_get_contents("http://timhieubiendao.daknong.vn/admin/vne/member/member/get/district?province_id=62"));
            foreach ($districts as $key1 => $value1){
                $data_district[$value1->district_id] = $value1->name;
            }
        }
        catch (\Exception $e){

        }
        $data_view = [
            'table' => [
                1 => 'Bảng A',
                2 => 'Bảng B'
            ],
            'city' => $data_city,
            'district' => !empty($data_district)?$data_district:[],
            'round' => ContestRound::where('round_type','real')->pluck('display_name','round_id'),
            'topic' => ContestTopic::where('topic_type','real')->pluck('display_name','topic_id'),
        ];
        return view('CONTEST-CONTESTMANAGE::modules.contestmanage.candidate.set_exam',$data_view);
    }


}