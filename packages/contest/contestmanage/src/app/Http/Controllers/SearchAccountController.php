<?php

namespace Contest\Contestmanage\App\Http\Controllers;

use Adtech\Application\Cms\Controllers\Controller as Controller;
use Adtech\Core\App\Models\Role;
use Adtech\Core\App\Models\User;
use Adtech\Core\App\Repositories\UserRepository;
use Contest\Contestmanage\App\ApiHash;
use Contest\Contestmanage\App\Http\Requests\SearchAccountRequest;
use Contest\Contestmanage\App\Models\UserSearchRole;
use Contest\Contestmanage\App\Repositories\FormLoadRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Activitylog\Models\Activity;
use Validator;
use Yajra\Datatables\Datatables;

class SearchAccountController extends Controller
{
    public function __construct(UserRepository $userRepository, FormLoadRepository $formLoadRepository)
    {
        parent::__construct();
        $this->account = $userRepository;
        $this->form_load = $formLoadRepository;
    }

    public function add(SearchAccountRequest $request)
    {
        $role = Role::where('alias','search')->first();
        if(empty($role)){
           $role = new Role();
           $role->name = "Tài khoản tra cứu";
           $role->alias = "search";
           $role->save();
        }
       $search_account = new User();
       $search_account->email = $request->email;
       $search_account->password = Hash::make($request->password);
       $search_account->contact_name = $request->name;
       $search_account->role_id = $role->role_id;

           try {
               $search_account->save();
               DB::connection('mysql_core')->insert('insert into adtech_core_users_role (user_id, role_id, created_at, updated_at) values (?, ?, ?, ?)',
                   [$search_account->user_id, $search_account->role_id, date('Y-m-d H:i:s'), date('Y-m-d H:i:s')]);
               $search_data = new UserSearchRole();
               $search_data->type = $request->type;
               $search_data->u_name = $request->email;
               $search_data->first_password = $request->password;
               $search_data->unit = $request->unit;
               $search_data->contact = $request->contact;
               $province_id = [];
               $district_id = [];
               $school_id = [];
               if($request->type == 'province'){
                   if(!empty($request->list_province_id)){
                       foreach ($request->list_province_id as $key => $value){
                           $province_id[$value] = $request->list_province_name[$key];
                       }
                   }
               }
               elseif($request->type == 'district'){
                   $province_id[$request->province_id] = $request->province_name;
                   if(!empty($request->list_district_id)){
                       foreach ($request->list_district_id as $key => $value){
                           $district_id[$value] = $request->list_district_name[$key];
                       }
                   }
               }

               elseif($request->type == 'school'){
                   $province_id[$request->province_id] = $request->province_name;
                   $district_id[$request->district_id] = $request->district_name;
                   if(!empty($request->list_school_id)){
                       foreach ($request->list_school_id as $key => $value){
                           $school_id[$value] = $request->list_school_name[$key];
                       }
                   }
               }


               $search_data->province_data = $province_id;
               $search_data->district_data = $district_id;
               $search_data->school_data = $school_id;
               $search_data->save();
               activity('search_account')
                   ->performedOn($search_account)
                   ->withProperties($request->all())
                   ->log('User: :causer.email - Add search_account - name: :properties.contact_name, _id: ' . $search_account->user_id);

               return redirect()->route('contest.contestmanage.search_account.manage')->with('success', trans('contest-contestmanage::language.messages.success.create'));
           }
           catch (\Exception $e) {
               return redirect()->route('contest.contestmanage.search_account.manage')->with('error', trans('contest-contestmanage::language.messages.error.create'));
           }
    }

    public function create()
    {
        $province_list = [];
        $filter_data = $this->form_load->getFilterField('backend','search_candidate');
        if(!empty($filter_data)){
            foreach ($filter_data as $key => $value){
                if($value['params'] == 'province_id'){
                    if(!empty($value['data_view'])){
                        foreach ($value['data_view'] as $key1 => $value1){
                            $province_list[$value1['key']] = $value1['value'];
                        }
                    }
                }
            }
        }
        $data_view = [
            'province_list' => $province_list,
            'type' => [
                'province' => 'Cấp tỉnh/tp',
                'district' => 'Cấp quận/ huyện',
                'school' => ' Cấp trường'
            ]
        ];
        return view('CONTEST-CONTESTMANAGE::modules.contestmanage.search_account.create', $data_view);
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

            return redirect()->route('contest.contestmanage.search_account.manage')->with('success', trans('contest-contestmanage::language.messages.success.delete'));
        } else {
            return redirect()->route('contest.contestmanage.search_account.manage')->with('error', trans('contest-contestmanage::language.messages.error.delete'));
        }
    }

    public function manage()
    {
       
        return view('CONTEST-CONTESTMANAGE::modules.contestmanage.search_account.manage');
    }

    public function show(Request $request)
    {
        $season = $this->contestSeason->find($request->season_id);
        $data = [
            'season' => $season,
            'environment' => $this->env->getEnvironment(),
            'season_config' => $this->seasonConfig->findBySeason($request->season_id)
        ];

        return view('CONTEST-CONTESTMANAGE::modules.contestmanage.search_account.edit', $data);
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
                $confirm_route = route('contest.contestmanage.search_account.delete', ['product_id' => $request->input('product_id')]);
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
            }
            catch (GroupNotFoundException $e) {
                return view('includes.modal_table', compact('error', 'model', 'confirm_route'));
            }
        }
        else {
            return $validator->messages();
        }
    }

    //Table Data to index page
    public function data(Request $request)
    {

        $start = (int)$request->start;
        $length = !empty($request->length)?(int)$request->length:10;
        $query = UserSearchRole::query();
        $total = $query->count();
        $query = $query->skip($start)->take($length)->get();
        $request->merge(['start' => 0]);
        return Datatables::of($query)
            ->setTotalRecords($total)
            ->make(true);
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

    public function storeExcel($data, $name, $module,$heading,$map)
    {
        ob_start();
        $store_path = $this->store_path.'/'.$module;
        if($module =='candidate'){
//            $export = new Exports( $data, 'candidate');
            $export = new Exports( $data, 'candidate',$heading,$map);
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



}