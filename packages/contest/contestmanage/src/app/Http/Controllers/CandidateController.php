<?php

namespace Contest\Contestmanage\App\Http\Controllers;

use Adtech\Application\Cms\Controllers\Controller as Controller;
use Contest\Contestmanage\App\ApiHash;
use Contest\Contestmanage\App\ContestFunc;
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
use Contest\Contestmanage\App\Models\NextRoundBuffer;
use Contest\Contestmanage\App\Models\School;
use Contest\Contestmanage\App\Models\SeasonConfig;
use Contest\Contestmanage\App\Models\UserContestInfo;
use Contest\Contestmanage\App\Models\UserContestInfo_Es;
use Contest\Contestmanage\App\Models\UserNextRound;
use Contest\Contestmanage\App\Models\UserSearchRole;
use Contest\Contestmanage\App\NextRoundImport;
use Contest\Contestmanage\App\Repositories\CandidateRepository;
use Contest\Contestmanage\App\Repositories\ContestConfigRepository;
use Contest\Contestmanage\App\Repositories\ContestSeasonRepository;
use Contest\Contestmanage\App\Repositories\ContestTargetRepository;
use Contest\Contestmanage\App\Repositories\FormLoadRepository;
use Contest\Contestmanage\App\Repositories\GroupExamRepository;
use Dhcd\Contest\App\Repositories\ContestRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Jenssegers\Mongodb\Schema\Blueprint;
use MongoDB\Client;
use PHPUnit\Runner\Exception;
use Spatie\Activitylog\Models\Activity;
use Tebru\Gson\Element\JsonElement;
use Tebru\Gson\Gson;
use Tebru\Gson\Internal\TypeAdapter\JsonElementTypeAdapter;
use Validator;
use Cache;
use Yajra\Datatables\Datatables;

class CandidateController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric' => "Phải là số"
    );

    public function __construct(FormLoadRepository $formLoadRepository ,ContestSeasonRepository $contestSeasonRepository, CandidateRepository $candidateRepository,
                                GroupExamRepository $groupExamRepository, ContestTargetRepository $targetRepository)
    {
        parent::__construct();
        $this->candidate = $candidateRepository;
        $this->contestSeason = $contestSeasonRepository;
        $this->groupExam = $groupExamRepository;
        $this->target = $targetRepository;
        $this->store_path = 'export/excel/';
        $this->form_load = $formLoadRepository;
        if($this->admin_type == 'search'){
            $search_roles = UserSearchRole::where('u_name',$this->user->email)->first();
            if(!empty($search_roles)){
                $this->search_type = $search_roles->type;
                $this->search_province_data = $search_roles->province_data;
                $this->search_district_data = $search_roles->district_data;
                $this->search_school_data = $search_roles->school_data;
            }
        }
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
        $field_list = [];
        try{
            $res_field = file_get_contents(config('site.url_cuocthi').'/resource/'.(new ApiHash(env('SECRET_KEY'),env('SECRET_IV')))->encrypt('dev/get/user_field?time='.(time()*1000)));
            if(!empty($res_field)){
                $flist = json_decode($res_field,true);
                foreach ($flist as $key => $value){
                    $field_list[$value['varible']] = $value['label'];
                }
            }
        }
        catch (\Exception $e){

        }
        $season = $this->contestSeason->getCurrentSeason();

//        $hash = new ApiHash(env('SECRET_KEY'),env('SECRET_IV'));
        $hash = new ApiHash('t+m:*meo6h}b?{~','*[Py49<>n@-VYr1');
        if(!empty($request->data)){
            $user_info = new UserContestInfo();
            $user_info->nextID();
            $info = $hash->decrypt(str_replace('\n','',$request->data));
            if(!empty($info)){
                $data = json_decode($info, true);
                if(!empty($data['token'])){
                    $client = new \GuzzleHttp\Client();
                    $headers = [
                        'Authorization' => 'Bearer ' . env('BEARER_TOKEN'),
                        'Accept'        => 'application/json',
                    ];
                    try{
                        $verify_res = $client->request('GET', 'http://eid.vnedutech.vn/api/verify?token='.$data['token'], [
                            'headers' => $headers
                        ])->getBody()->getContents();
                        if(!empty($verify_res)){
                            $verify_res = json_decode($verify_res);
                            if($verify_res->success == true){
                                    if(!empty($verify_res->data->user_id) && !empty($verify_res->data->username)){
                                        if(UserContestInfo::count() >0){
                                            $check_info = UserContestInfo::where('member_id', (int)$verify_res->data->user_id)->orWhere('u_name',$verify_res->data->username)->first();
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
                                            $check2_condition = [];
                                            $user_info->member_id = (int)$verify_res->data->user_id;
                                            $user_info->u_name = $verify_res->data->username;
                                            foreach ($data as $key=>$value){
//                                                if($key == 'member_id'){
//                                                    $user_info->$key = (int)$value;
//                                                }
//                                                elseif($key == 'u_name'){
////                                                    $user_info->$key = strtolower($value);
//                                                    $user_info->$key = $value;
//                                                }
                                                if($key == 'name'){
                                                    $user_info->$key = $value;
                                                    $check2_condition['name'] = $user_info->$key;
                                                }
                                                elseif($key == 'birthday'){
                                                    try{
                                                        $user_info->$key = date_create_from_format('d-m-Y', $value)->date;
                                                    }
                                                    catch(\Exception $e){
                                                        $user_info->$key = $value;
                                                    }
                                                    $check2_condition['birthday'] = $user_info->$key;
                                                }
                                                elseif($key == 'object_id'){
                                                    $user_info->$key = (int)$value;
                                                }
                                                elseif($key == 'province_id'){
                                                    if($value == 0 || $value == "0"){
                                                        $res = [
                                                            'success' => false,
                                                            'messages' => 'Có thông tin chưa đúng, vui lòng thử lại!',
                                                            'data' => null
                                                        ];
                                                        return response()->json($res);
                                                    }
                                                    else{
                                                        $user_info->$key = (int)$value;
                                                    }

                                                }
                                                elseif($key == 'school_id'){
                                                    if($value == 0 || $value == "0"){
                                                        $res = [
                                                            'success' => false,
                                                            'messages' => 'Có thông tin chưa đúng, vui lòng thử lại!',
                                                            'data' => null
                                                        ];
                                                        return response()->json($res);
                                                    }
                                                    else {
                                                        $user_info->$key = (int)$value;
                                                        $check2_condition['school_id'] = $user_info->$key;
                                                    }
                                                }
                                                elseif($key == 'class_id'){
                                                    if($value == 0 || $value == "0"){
                                                        $res = [
                                                            'success' => false,
                                                            'messages' => 'Có thông tin chưa đúng, vui lòng thử lại!',
                                                            'data' => null
                                                        ];
                                                        return response()->json($res);
                                                    }
                                                    else {
                                                        $user_info->$key = (int)$value;
                                                        $check2_condition['class_id'] = $user_info->$key;
                                                    }
                                                }
                                                elseif($key == 'district_id'){
                                                    if($value == 0 || $value == "0"){
                                                        $res = [
                                                            'success' => false,
                                                            'messages' => 'Có thông tin chưa đúng, vui lòng thử lại!',
                                                            'data' => null
                                                        ];
                                                        return response()->json($res);
                                                    }
                                                    else {
                                                        $user_info->$key = (int)$value;
                                                    }
                                                }
                                                elseif($key == 'table_id'){
                                                    if($value == 0 || $value == "0"){
                                                        $res = [
                                                            'success' => false,
                                                            'messages' => 'Có thông tin chưa đúng, vui lòng thử lại!',
                                                            'data' => null
                                                        ];
                                                        return response()->json($res);
                                                    }
                                                    else {
                                                        $user_info->$key = (int)$value;
                                                    }
                                                }
                                                elseif($key == 'province_name' || $key == 'district_name' || $key == 'school_name'){
                                                    if($value == "" || $value == null){
                                                        $res = [
                                                            'success' => false,
                                                            'messages' => 'Có thông tin chưa đúng, vui lòng thử lại!',
                                                            'data' => null
                                                        ];
                                                        return response()->json($res);
                                                    }
                                                    else {
                                                        $user_info->$key = $value;
                                                    }
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
                                            $check_info2 = UserContestInfo::where($check2_condition)->count();
                                            if($check_info2 > 0){
                                                $res = [
                                                    'success' => false,
                                                    'messages' => "Thông tin đăng ký đã tồn tại trên hệ thống!",
                                                    'data' => array()
                                                ];
                                                return response()->json($res);
                                            }
                                            else{
                                                try {
                                                    $user_info->save();
                                                    $user_info->addToIndex();
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
                                    }
                                    else{
                                        $res = [
                                            'success' => false,
                                            'messages' => 'Thông tin không khớp!',
                                            'data' => null
                                        ];
                                        return response()->json($res);
                                    }

                            }
                            else{
                                $res = [
                                    'success' => false,
                                    'messages' => !empty($verify_res->messages)?$verify_res->messages:'Có lỗi trong quá trình đăng ký, vui lòng thử lại sau!',
                                    'data' => null
                                ];
                                return response()->json($res);
                            }
                        }
                    }
                    catch (\Exception $e){
                        $res = [
                            'success' => false,
                            'messages' => 'Có lỗi trong quá trình đăng ký, vui lòng thử lại sau!',
                            'data' => null
                        ];
                        return response()->json($res);
                    }
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
                            foreach ($user_info->getAttributes() as $key3 => $value3){
                                if(!in_array($key3, ['_id', 'member_id','accept_rule','season', 'school_id', 'district_id', 'province_id', 'table_id'])){
                                    $data_item = new \stdClass();
//                                    $data_item->title = !empty($field_list[$key3])?$field_list[$key3]:$key3;
                                    if($key3 == 'school_name'){
                                        $data_item->title = !empty($field_list['school_id'])?$field_list['school_id']:$key3;
                                    }
                                    elseif($key3 == 'district_name'){
                                        $data_item->title = !empty($field_list['district_id'])?$field_list['district_id']:$key3;
                                    }
                                    elseif($key3 == 'province_name'){
                                        $data_item->title = !empty($field_list['province_id'])?$field_list['province_id']:$key3;
                                    }
                                    else{
                                        $data_item->title = !empty($field_list[$key3])?$field_list[$key3]:$key3;
                                    }

                                    $data_item->value = $value3;
                                    $res_data[] = $data_item;
                                }

                            }
                            $res = [
                                'success' => true,
                                'messages' => null,
                                'data' => $res_data
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
//        UserContestInfo_Es::putMapping();
        $filter_data = $this->form_load->getFilterField('backend','search_candidate');
        $result_data = $this->form_load->getResultField('backend','search_candidate');
        if($this->admin_type == 'search'){
            $province_data = !empty($this->search_province_data)?$this->search_province_data:null;
            $district_data = !empty($this->search_district_data)?$this->search_district_data:null;
            $school_data = !empty($this->search_school_data)?$this->search_school_data:null;
        }
        elseif(!empty($this->admin_type)){
            $province_data = $this->search_province_data;
            $district_data = $this->district_data;
            $school_data = $this->school_data;
        }
        $data_view = [
            'filter_data' => $filter_data,
            'result_data' => $result_data,
            'search_type' => !empty($this->search_type)?$this->search_type:null,
            'province_data' => !empty($province_data)?$province_data:null,
            'district_data' => !empty($district_data)?$district_data:null,
            'school_data' => !empty($school_data)?$school_data:null,
            'round' => ContestRound::where('round_type','real')->pluck('display_name','round_id'),
            'topic' => ContestTopic::where('topic_type','real')->pluck('display_name','topic_id')
        ];
        if($this->admin_type == 'search'){
            if($this->search_type == 'province'){
                return view('CONTEST-CONTESTMANAGE::modules.contestmanage.candidate.manage_province',$data_view);
            }
            elseif($this->search_type == 'district'){
                return view('CONTEST-CONTESTMANAGE::modules.contestmanage.candidate.manage_district',$data_view);
            }
            elseif($this->search_type == 'school'){
                return view('CONTEST-CONTESTMANAGE::modules.contestmanage.candidate.manage_school',$data_view);
            }
        }
        elseif($this->admin_type == 'province'){
            return view('CONTEST-CONTESTMANAGE::modules.contestmanage.candidate.manage_province',$data_view);
        }

        elseif($this->admin_type == 'province'){
            return view('CONTEST-CONTESTMANAGE::modules.contestmanage.candidate.manage_district',$data_view);
        }

        elseif($this->admin_type == 'province'){
            return view('CONTEST-CONTESTMANAGE::modules.contestmanage.candidate.manage_school',$data_view);
        }
        else{
            return view('CONTEST-CONTESTMANAGE::modules.contestmanage.candidate.manage',$data_view);
        }

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

        if($this->admin_type == 'search'){
            if($this->search_type == 'province'){
                if(!empty($params['province_id'])){
                    if(!empty($this->search_province_data)){
                        $province_arr = [];
                        foreach ($this->search_province_data as $key => $value){
                            $province_arr[] = $key;
                        }
                        if(!in_array($params['province_id'],$province_arr)){
                            $params['province_id'] = -1;
                        }
                    }
                }
                else{
                    $params['province_id'] = -1;
                }
            }
            elseif($this->search_type == 'district'){
                if(!empty($params['district_id'])){
                    if(!empty($this->search_district_data)){
                        $district_arr = [];
                        foreach ($this->search_district_data as $key => $value){
                            $district_arr[] = $key;
                        }
                        if(!in_array($params['district_id'],$district_arr)){
                            $params['district_id'] = -1;
                        }
                    }
                }
                else{
                    $params['province_id'] = -1;
                }
            }
            elseif($this->search_type == 'school'){
                if(!empty($params['school_id'])){
                    if(!empty($this->search_school_data)){
                        $school_arr = [];
                        foreach ($this->search_school_data as $key => $value){
                            $school_arr[] = $key;
                        }
                        if(!in_array($params['school_id'],$school_arr)){
                            $params['school_id'] = -1;
                        }
                    }
                }
                else{
                    $params['school_id'] = -1;
                }
            }
        }
        elseif($this->admin_type == 'province'){

        }
        $start = (int)$request->start;
        $length = !empty($request->length)?(int)$request->length:10;
//        $query = UserContestInfo::query()->where($params);
//        $query = UserContestInfo::searchByQuery(['match' => $params],null,null,$length,$start);
        $query = UserContestInfo::customSearch($params,$start,$length);
//        echo '<pre>';print_r($query->chunk(10));echo '</pre>';
//        if(!empty($request->name)){
//            $query = UserContestInfo::query()->where($params)->where('name','like','%'.$request->name.'%');
//        }

        $total = $query->totalHits();
//        $query = $query->take($length)->all();
        $request->merge(['start' => 0]);
        return Datatables::of($query)->setTotalRecords($total)->make(true);
    }

    public function dataResult(Request $request)
    {
        $cond = [];
        $name = null;
        $round_list = [];
        $rounds = ContestRound::where(['type' => 'online','round_type' => 'real'])->get();
        if(!empty($rounds)){
            foreach ($rounds as $round){
                $round_list[$round->round_id] = base64_decode($round->display_name);
            }
        }
        $topic_list = ContestTopic::where(['type' => 'online','topic_type' => 'real'])->pluck('display_name','topic_id');
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
        if (!empty($request->round_id) && $request->round_id != 0) {
            $cond['round_id'] = (int)$request->round_id;
        }
        if (!empty($request->topic_id) && $request->topic_id != 0) {
            $cond['topic_id'] = (int)$request->topic_id;
        }
        if (!empty($request->u_name)) {
            $cond['u_name'] = $request->u_name;
        }
        if (!empty($request->name)) {
            $cond['name'] = $request->name;
        }

        $result = ContestResult::where($cond)->orderBy('total_point', 'desc')->orderBy('used_time', 'asc');
        $total = $result->count();
        $start = (int)$request->start;
        $length = !empty($request->length)?(int)$request->length:10;
        $result = $result->skip($start)->take($length)->get();
        $request->merge(['start' => 0]);
        return Datatables::of($result)
            ->setTotalRecords($total)
            ->editColumn('round_id', function ($res) use ($round_list) {
            return !empty($round_list[$res->round_id])?$round_list[$res->round_id]:"";
            })
            ->editColumn('topic_id', function ($res) use($topic_list) {
            return !empty($topic_list[$res->topic_id])?$topic_list[$res->topic_id]:"";
            })
            ->editColumn('used_time', function ($res) {
            return (new ContestFunc())->convertExamTime($res->used_time);
            })
            ->rawColumns(['round_id','topic_id','used_time'])->make(true);
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
            if(!empty($request->alias)){
                $result_data = $this->form_load->getResultField('backend',$request->alias);
                $heading = [];
                $mapping = [];
                if(!empty($result_data)){
                    foreach ($result_data as $key => $value){
                        if(!empty($value['params_hidden'])){
                            $mapping[] = $value['params_hidden'];
                        }
                        else{
                            $mapping[] = $value['params'];
                        }
                        $heading[] = $value['title'];

                    }
                }
            }
            $store_path = $this->store_path.'/'.$request->module;
            if($request->module == 'result'){

                try {
                    $current_date = date('Ymd', time());
                    $req = $request->all();
                    $name = 'ds_ketquathi_' . $current_date. '.xlsx';

                    if ($this->storeExcel( $req, $name, $request->module, $heading, $mapping)) {
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

                    if ($this->storeExcel( $req, $name, $request->module, $heading, $mapping)) {
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

    public function exportNextRound(Request $request){
        $req = $request->all();
        $heading = ['STT','Tỉnh/TP','Quận/huyện','Trường','Lớp','Username','Họ tên','Ngày sinh','Điểm cao nhất','Thời gian thi','Cấp'];
        $mapping = ['id','province_name','district_name','school_name','class_id','u_name','name','birthday','total_point','used_time','target'];
        if(!empty($request->province_id)){
            $store_path = $this->store_path.'/next_round/';
            try {
                $current_date = date('Ymd', time());
                $name = 'export_' . $current_date. '.xlsx';

                if ($this->storeExcelFromCollection( $req, $name, 'next_round', $heading, $mapping)) {
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
    public function exportUserNotEnoughInfo(Request $request){
        $req = $request->all();
        $heading = ['STT','Tỉnh/TP','Quận/huyện','Trường','Lớp','Username','Họ tên','Ngày sinh','Bảng'];
        $mapping = ['member_id','province_name','district_name','school_name','class_id','u_name','name','birthday','target'];

        $store_path = $this->store_path.'/next_round/';
        try {
            $current_date = date('Ymd', time());
            $name = 'export_' . $current_date. '.xlsx';

            if ($this->storeExcelFromCollection( $req, $name, 'user_not_enough_info', $heading, $mapping)) {
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

    public function storeExcel($data, $name, $module,$heading,$map)
    {
        ob_start();
        $store_path = $this->store_path.'/'.$module;
        if($module =='candidate'){
//            $export = new Exports( $data, 'candidate');
            $export = new Exports( $data, 'candidate',$heading,$map);
        }
        elseif ($module =='next_round'){
            $export = new Exports( $data, 'next_round',$heading,$map);
        }
        else{
            $export = new Exports( $data, 'result',$heading,$map);
        }
        ob_end_clean();
        return $export->store($store_path . $name);
    }

    public function storeExcelFromCollection($data, $name, $module,$heading,$map)
    {
        ob_start();
        $store_path = $this->store_path.'/'.$module.'/';
        if(!empty($module)){
            $export = new ExportFromCollection( $data, $module,$heading,$map);
        }
        else{
            $export = new ExportFromCollection( $data, 'result');
        }
        ob_end_clean();
        return $export->store($store_path . $name);
    }

    public function result()
    {
        $filter_data = $this->form_load->getFilterField('backend','search_result');
        $result_data = $this->form_load->getResultField('backend','search_result');
        $data_view = [
            'filter_data' => $filter_data,
            'result_data' => $result_data,
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

    public function nextRoundFilter(Request $request){
        $schools = [];
        if(!empty($request->level)){
            $schools = School::where('schoollevel', (int)$request->level)->get()->toArray();
        }
        elseif(Cache::tags(config('site.cache_tag'))->has('school_distinct')){
            $schools = Cache::tags(config('site.cache_tag'))->get('school_distinct');
        }
        else{
            $schools = ContestResult::distinct('school_id')->get()->toArray();
            Cache::tags(config('site.cache_tag'))->forever('school_distinct', $schools);
        }
        if(!empty($request->page)){
            $take = 1000;
            $skip = ((int)$request->page - 1)*$take;
            if($request->page == 1){
                $skip = 2;
            }
            $schools = array_slice($schools,$skip,$take);
        }

//        $schools = ContestResult::distinct('member_id')->take(100)->get()->count();
//        echo '<pre>';print_r($schools);echo '</pre>';die;
//        echo '<pre>';print_r($list);echo '</pre>';die;
//        $schools = [];
//        if(!empty($request->page)){
//            $limit = 10000;
//            $skip = ((int)$request->page -1) * 10000;
//            $schools = School::select('_id')->whereIn('schoollevel',[2,3])->skip($skip)->take($limit)->get()->toArray();
//        }
        $data_view = [
            'schools' => $schools
        ];
        return view('CONTEST-CONTESTMANAGE::modules.contestmanage.candidate.next_round_filter',$data_view);
    }

    public function checkUserExamStatus(Request $request){
        if(!empty($request->round_id)){

        }
    }

    public function dataNextRound(Request $request){
        $res = [
            'success' => true,
            'data' => [],
            'messages' => ''
        ];
        $data = [];
        $aggregate = [];
        $match = [];
        if(!empty($request->id)){
//            $test = ContestResult::where('school_id', (int)$request->id)->orderBy('total_point', 'desc')->orderBy('used_time','desc');
            $match['school_id'] = (int)$request->id;
            array_unshift($aggregate, ['$match' => $match]);
            $aggregate[] = [
                '$sort' => [
                    'total_point' => -1,
                    'used_time' => 1
                ]
            ];
            $aggregate[] = [
                '$in' => ['$class_id' => [10,11,12]]
            ];
            $aggregate[] = [
                '$group' => [
                    '_id' => '$member_id',
                    'topic' => [
                        '$addToSet' => '$topic_id'
                    ],
                    'point' => [
                        '$max' => '$total_point'
                    ],
                    'time' => [
                        '$push' => '$$ROOT'
                    ],
                    'name' => [
                        '$first' => '$name'
                    ],
                    'u_name' => [
                        '$first' => '$u_name'
                    ],
                    'birthday' => [
                        '$first' => '$birthday'
                    ],
                    'email' => [
                        '$first' => '$email'
                    ],
                    'phone_user' => [
                        '$first' => '$phone_user'
                    ],
                    'province_id' => [
                        '$first' => '$province_id'
                    ],
                    'province_name' => [
                        '$first' => '$province_name'
                    ],
                    'district_id' => [
                        '$first' => '$district_id'
                    ],
                    'district_name' => [
                        '$first' => '$district_name'
                    ],
                    'school_id' => [
                        '$first' => '$school_id'
                    ],
                    'class_id' => [
                        '$first' => '$class_id'
                    ],
                    'school_name' => [
                        '$first' => '$school_name'
                    ],
                    'target' => [
                        '$first' => '$target'
                    ]
                ]
            ];
            $aggregate[] = [
                '$project' => [
                    '_id' => 1,
                    'topic_count' => [
                        '$size' => '$topic'
                    ],
                    'total_point' => '$point',
                    'used_time' => ['$arrayElemAt' => ['$time.used_time',0]],
                    'name' => 1,
                    'u_name' => 1,
                    'birthday' => 1,
                    'email' => 1,
                    'phone_user' => 1,
                    'province_id' => 1,
                    'province_name' => 1,
                    'district_id' => 1,
                    'district_name' => 1,
                    'school_id' => 1,
                    'class_id' => 1,
                    'school_name' => 1,
                    'target' => 1
                ]
            ];
            $aggregate[] = [
                '$sort' => [
                    'total_point' => -1,
                    'used_time' => 1
                ]
            ];
            $aggregate[] = [
                '$match' => [
                    'topic_count' => ['$gt' => 1]
                ]
            ];
            $aggregate[] = [
                '$limit' => 5
            ];
//            $list = ContestResult::where('school_id', (int)$request->id)->orderBy('total_point', 'desc')->orderBy('used_time','desc')->take(50)->get();
//            $list = ContestResult::query()->where('school_id', (int)$request->id)->orderBy('total_point', 'desc')->orderBy('used_time','asc');
            $list = ContestResult::raw(function ($collection) use ( $aggregate) {
//            $list = $test->raw(function ($collection) use ( $aggregate) {
                return $collection->aggregate($aggregate);
            });
            if(!empty($list)){
                foreach ($list as $key => $value){
                    $data[] = [
                        'member_id' => $value->_id ?? null,
//                            'round_id' => $value->round_id ?? null,
//                            'topic_id' => $value->topic_id ?? null,
                        'name' => $value->name ?? null,
                        'u_name' => $value->u_name ?? null,
                        'total_point' => $value->total_point ?? null,
                        'used_time' => $value->used_time ?? null,
                        'repeat_time' => $value->repeat_time ?? null,
                        'birthday' => $value->birthday ?? null,
                        'email' => $value->email ?? null,
                        'phone' => $value->phone ?? null,
                        'topic_count' => $value->topic_count ?? null,
                        'phone_user' => $value->phone_user ?? null,
                        'province_id' => $value->province_id ?? null,
                        'province_name' => $value->province_name ?? null,
                        'district_id' => $value->district_id ?? null,
                        'district_name' => $value->district_name ?? null,
                        'school_id' => $value->school_id ?? null,
                        'class_id' => $value->class_id ?? null,
                        'school_name' => $value->school_name ?? null,
                        'target' => $value->target ?? null,
                        'level' => 2
                    ];
                }
                try{
                    NextRoundBuffer::insert($data);
                    $res['success'] = true;
                    $res['messages'] = $request->id.' - done';
                }
                catch (\Exception $e){
                    $res['messages'] = $request->id.' - error - '. $e->getMessage();
                }
            }

        }
        return response()->json($res);
    }

    public function listNextRound(Request $request){
        $provinces = '[
                {
                    "key": "1",
                    "value": "Thanh Hóa"
                },
                {
                    "key": "2",
                    "value": "Nghệ An"
                },
                {
                    "key": "7",
                    "value": "Hà Giang"
                },
                {
                    "key": "3",
                    "value": "Hà Tĩnh"
                },
                {
                    "key": "10",
                    "value": "Lạng Sơn"
                },
                {
                    "key": "4",
                    "value": "Quảng Bình"
                },
                {
                    "key": "18",
                    "value": "Tiền Giang"
                },
                {
                    "key": "5",
                    "value": "Quảng Trị"
                },
                {
                    "key": "9",
                    "value": "Bắc Kạn"
                },
                {
                    "key": "15",
                    "value": "Quảng Ninh"
                },
                {
                    "key": "13",
                    "value": "Bắc Giang"
                },
                {
                    "key": "19",
                    "value": "An Giang"
                },
                {
                    "key": "16",
                    "value": "Long An"
                },
                {
                    "key": "20",
                    "value": "Bến Tre"
                },
                {
                    "key": "54",
                    "value": "Yên Bái"
                },
                {
                    "key": "52",
                    "value": "Bình Thuận"
                },
                {
                    "key": "8",
                    "value": "Cao Bằng"
                },
                {
                    "key": "6",
                    "value": "Thừa Thiên Huế"
                },
                {
                    "key": "55",
                    "value": "Điện Biên"
                },
                {
                    "key": "53",
                    "value": "Lào Cai"
                },
                {
                    "key": "58",
                    "value": "Sơn La"
                },
                {
                    "key": "57",
                    "value": "Lai Châu"
                },
                {
                    "key": "59",
                    "value": "Kon Tum"
                },
                {
                    "key": "56",
                    "value": "Hòa Bình"
                },
                {
                    "key": "60",
                    "value": "Gia Lai"
                },
                {
                    "key": "14",
                    "value": "Phú Thọ"
                },
                {
                    "key": "21",
                    "value": "Vĩnh Long"
                },
                {
                    "key": "63",
                    "value": "Lâm Đồng"
                },
                {
                    "key": "61",
                    "value": "Đắk Lắk"
                },
                {
                    "key": "62",
                    "value": "Đắk Nông"
                },
                {
                    "key": "17",
                    "value": "Đồng Tháp"
                },
                {
                    "key": "11",
                    "value": "Tuyên Quang"
                },
                {
                    "key": "37",
                    "value": "Thái Bình"
                },
                {
                    "key": "22",
                    "value": "Trà Vinh"
                },
                {
                    "key": "25",
                    "value": "Sóc Trăng"
                },
                {
                    "key": "29",
                    "value": "Bắc Ninh"
                },
                {
                    "key": "48",
                    "value": "Bình Định"
                },
                {
                    "key": "23",
                    "value": "Hậu Giang"
                },
                {
                    "key": "46",
                    "value": "Quảng Nam"
                },
                {
                    "key": "30",
                    "value": "Hà Nam"
                },
                {
                    "key": "49",
                    "value": "Phú Yên"
                },
                {
                    "key": "47",
                    "value": "Quảng Ngãi"
                },
                {
                    "key": "24",
                    "value": "Kiên Giang"
                },
                {
                    "key": "26",
                    "value": "Bạc Liêu"
                },
                {
                    "key": "34",
                    "value": "Hưng Yên"
                },
                {
                    "key": "50",
                    "value": "Khánh Hòa"
                },
                {
                    "key": "32",
                    "value": "Hải Dương"
                },
                {
                    "key": "51",
                    "value": "Ninh Thuận"
                },
                {
                    "key": "33",
                    "value": "Hải Phòng"
                },
                {
                    "key": "45",
                    "value": "Đà Nẵng"
                },
                {
                    "key": "40",
                    "value": "Bình Dương"
                },
                {
                    "key": "31",
                    "value": "Hà Nội"
                },
                {
                    "key": "42",
                    "value": "Tây Ninh"
                },
                {
                    "key": "35",
                    "value": "Nam Định"
                },
                {
                    "key": "38",
                    "value": "Vĩnh Phúc"
                },
                {
                    "key": "27",
                    "value": "Cà Mau"
                },
                {
                    "key": "39",
                    "value": "Bình Phước"
                },
                {
                    "key": "41",
                    "value": "Đồng Nai"
                },
                {
                    "key": "12",
                    "value": "Thái Nguyên"
                },
                {
                    "key": "28",
                    "value": "Cần Thơ"
                },
                {
                    "key": "43",
                    "value": "Bà Rịa - Vũng Tàu"
                },
                {
                    "key": "36",
                    "value": "Ninh Bình"
                },
                {
                    "key": "44",
                    "value": "Tp.Hồ Chí Minh"
                }
            ]';
        return view('CONTEST-CONTESTMANAGE::modules.contestmanage.candidate.list_next_round',['provinces' => json_decode($provinces), 'rounds' => ContestRound::pluck('round_name','round_id')]);
    }

    public function dataListNextRound(Request $request)
    {

        if (!empty($request->province_id) && $request->province_id != 0) {
            $province_id = (int)$request->province_id;

            $result = [];
            $schools = NextRoundBuffer::where('province_id', $province_id)->distinct()->select('school_id')->get()->toArray();
            if(!empty($schools)){
                foreach ($schools as $item){
                    $exams = DB::connection('mysql_cuocthi')->table('contest_buffers')->where('school_id', (int)$item['school_id'])->groupBy('member_id')->orderBy('total_point','desc')->orderBy('used_time','asc')->get()->toArray();
                    if(!empty($exams)){
                        foreach ($exams as $exam){
//                            $result[] = ContestResult::where('member_id', (int)$exam['member_id'])->orderBy('total_point','desc')->orderBy('used_time','desc')->first()->toArray();
                            $result[] = $exam;
                        }
                    }
                }
            }

//        $request->merge(['start' => 0]);
            return Datatables::make($result)
                ->editColumn('used_time', function ($res) {
                    return (new ContestFunc())->convertExamTime($res->used_time);
                })->make(true);
        }
    }

    public function dataUserNotEnoughInfo(Request $request)
    {

        $result = UserContestInfo::where('target','$exist',false)->orWhere('target', null)
            ->orWhere(function ($query){
                return $query->where('target','group_a')->where('nation','$exists',false);
            })
            ->orWhere(function ($query){
                return $query->where('target','group_a')->where('nation',null);
            })
            ->orWhere(function ($query){
                return $query->where('target','group_a')->where('nation','nation_1')->where('province_name',null);
            })
            ->orWhere(function ($query){
                return $query->where('target','group_a')->where('nation','nation_1')->where('school_name',null);
            })
            ->orWhere(function ($query){
                return $query->where('target','group_a')->where('nation','nation_1')->where('province_name','$exists',false);
            })
            ->orWhere(function ($query){
                return $query->where('target','group_b')->where('job','$exists',false);
            })
            ->orWhere(function ($query){
                return $query->where('target','group_b')->where('job',null);
            })
            ->orWhere(function ($query){
                return $query->where('target','group_b')->where('job','job_1')->where('school_name',null);
            })
            ->orWhere(function ($query){
                return $query->where('target','group_b')->where('province_name','$exists',false);
            })
            ->orWhere(function ($query){
                return $query->where('target','group_b')->where('province_name',null);
            })
            ->get();

//        $request->merge(['start' => 0]);
            return Datatables::make($result)->make(true);

    }

    public function syncPoint(Request $request){
       $list = NextRoundBuffer::where('is_sync',1)->take(1000)->get();
       if(!empty($list)){
            foreach ($list as $item){
                if(!empty($item->member_id)){
                    $result = ContestResult::where('member_id', (int)$item->member_id)->orderBy('total_point','desc')->orderBy('used_time','asc')->first();
                    if(!empty($result)){
                        $item->total_point = $result->total_point;
                        $item->used_time = $result->used_time;
                        $item->is_sync = 2;
                        if($item->update()){
                            echo '<pre>';print_r($item->id . ' - done');echo '</pre>';
                        }
                    }
                }
            }
       }
       else{
           echo '<pre>';print_r('all done');echo '</pre>';
       }
    }

    public function importNextRoundData(Request $request){
        $res = [
            'success' => false,
            'data' => [],
            'messages' => ''
        ];
        $import_data = [];
        if ($request->hasFile('file_upload')) {
            $file = $request->file_upload;
            if ($file->getMimeType() == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' || $file->getMimeType() == 'application/vnd.ms-excel') {
                if ($file->getClientOriginalExtension() == 'xls' || $file->getClientOriginalExtension() == 'xlsx') {
                    if ($file->getSize() < 10000000) {
                        $data = (new NextRoundImport())->toArray($file);
                        $data = $data[0];
                        if(count($data) > 1) {
                            foreach ($data as $key => $item) {
                                $user_info = UserContestInfo::where('u_name', (string)$item[0])->first();
                                if(!empty($user_info)){
                                    $import_item = [];
                                    foreach ($user_info->getAttributes() as $key2 => $value2){
                                        $import_item[$key2] = $value2;
                                    }
                                    $import_item['round_id'] = (int)$request->round_id;
                                    unset($import_item['_id']);
                                    unset($import_item['created_at']);
                                    unset($import_item['updated_at']);
                                    $import_data[] = $import_item;
                                }
                                else{
                                    $res['messages'] = 'Không tim thấy User tại dòng thứ '. ($key +1 );
                                    return response()->json($res);
                                }
                            }
                            if(!empty($import_data)){
                                try{
                                    if(UserNextRound::insert($import_data)){
                                        $res['success'] = true;
                                    }
                                }
                                catch (\Exception $e){
                                    $res['messages'] = 'Có lỗi xảy ra, vui lòng thử lại';
                                }
                            }
                        }
                        else{
                            $res['messages'] = 'Danh sách rỗng, vui lòng kiểm tra lại';
                        }

                    }
                    else{
                        $res['messages'] = 'Dung lượng file quá lớn, vui lòng upload file với dung lượng < 10MB';
                    }
                }
                else{
                    $res['messages'] = 'File không hợp lệ, vui lòng chỉ upload file excel';
                }
            }
            else{
                $res['messages'] = 'File không hợp lệ, vui lòng chỉ upload file excel';
            }
        }
        else{
            $res['messages'] = 'Vui lòng nhập file excel';
        }
        return response()->json($res);
    }

    public function dataImportNextRound(Request $request){
        $params = [];
        if(!empty($request->province_id)){
            $params['province_id'] = (int) $request->province_id;
        }
        $start = (int)$request->start;
        $length = !empty($request->length)?(int)$request->length:10;
        $query = UserNextRound::query()->where($params);
        $total = $query->count();
        $query = $query->skip($start)->take($length)->get();
        $request->merge(['start' => 0]);
        return Datatables::of($query)->setTotalRecords($total)->make(true);
    }

    public function getSyncEs(){
//        UserContestInfo::createIndex(20);
        return view('CONTEST-CONTESTMANAGE::modules.contestmanage.candidate.sync_es');
    }

    public function syncEs(Request $request){
        if(!empty($request->type)) {
            if (!empty($request->page)) {
                $limit = !empty($request->limit) ? (int)$request->limit : 2000;
                if ($request->type == 'result') {
                    $list = ContestResult::where('sync_es', null)->take($limit)->get();
                }
                elseif($request->type == 'candidate'){
                    $list = UserContestInfo::where('sync_es', 1)->take($limit)->get();
                }


                if (!empty($list)) {
                    try {
                        $list->addToIndex();
                        $arr = [];
                        foreach ($list as $item){
                            $arr[] = $item->_id;
                        }
                        if ($request->type == 'result') {
                            ContestResult::whereIn('_id',$arr)->update(['sync_es' => 2]);
                        }
                        elseif($request->type == 'candidate'){
                            UserContestInfo::whereIn('_id',$arr)->update(['sync_es' => 2]);
                        }
                        echo "<pre>";
                        print_r($request->page . ' - done');
                        echo "</pre>";
                    } catch (\Exception $e) {
                        echo "<pre>";
                        print_r($e->getMessage());
                        echo "</pre>";
                        die;
                    }
                } else {
                    echo "<pre>";
                    print_r('all done');
                    echo "</pre>";
                    die;
                }
            }
        }
    }
}