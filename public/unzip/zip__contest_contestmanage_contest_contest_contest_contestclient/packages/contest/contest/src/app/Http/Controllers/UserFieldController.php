<?php

namespace Contest\Contest\App\Http\Controllers;

use Contest\Contest\App\ApiHash;
use Contest\Contest\App\Models\UserField;
use Contest\Contest\App\Repositories\UserFieldRepository;
use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator;

class UserFieldController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );

    private $html_type_list = [
        0 => 'input',
        1 => 'selectbox',
        2 => 'radio',
        3 => 'checkbox'
    ];

    private $type = [
        0 => [
            'text' => 'Text',
            'number' => "Number",
            'date' => "Date",
            'datetime' => "Datetime"
        ],
        1 => [
            'data' => 'Data',
            'api' => "Api",
            'data_api' => "Data from api"
        ]
    ];
    private $data_type = [
        'string' => 'String',
        'integer' => 'Integer',
        'float' => 'Float',
        'double' => 'Double',
        'boolean' => 'Boolean'
    ];


    public function __construct(UserFieldRepository $fieldRepository)
    {
        parent::__construct();
        $this->field = $fieldRepository;
    }

    public function add(Request $request)
    {
        $field = new UserField();

        $field->label = $request->label;
        $field->varible = $request->varible;
        $field->type_name = $request->type_name;
        $field->hint_text = $request->hint_text;
        if(isset($request->params_hidden)){
            $field->params_hidden = $request->params_hidden;
        }
        if(!empty($request->dataview)){
            $data_view = [];
            foreach ($request->dataview['key'] as $key => $value){
                $data_view[$key] = new \stdClass();
                $data_view[$key]->key = $value;
                $data_view[$key]->value = $request->dataview['value'][$key];
            }
            $field->data_view = json_encode($data_view);
        }

        if(!empty($request->api)){
            $field->api = $request->api;
            $field->parent_field = !empty($request->parent_field)?$request->parent_field:null;
        }
        if(!empty($request->type)){
            $field->type = $request->type;
        }
        $field->type_id = $request->type_id;
        $field->data_type = $request->data_type;
        $field->description = !empty($request->description)?$request->description:null;
        $field->is_default = !empty($request->is_default)?1:0;
        $field->is_require = !empty($request->is_require)?1:0;
        $field->is_search = !empty($request->is_search)?1:0;
        $field->show_on_info = !empty($request->show_on_info)?1:0;
        $field->show_on_result = !empty($request->show_on_result)?1:0;
        $field->status = 1;

        $field->save();

        if ($field->field_id) {

            activity('user_field') 
                ->performedOn($field)
                ->withProperties($request->all())
                ->log('User: :causer.email - Add user_field - name: :properties.label, field_id: ' . $field->field_id);

            return redirect()->route('contest.contest.user_field.manage')->with('success', trans('contest-contest::language.messages.success.create'));
        } else {
            return redirect()->route('contest.contest.user_field.manage')->with('error', trans('contest-contest::language.messages.error.create'));
        }
    }

    public function create()
    {
//        dd((new ApiHash(env('SECRET_KEY'),env('SECRET_IV')))->encrypt('dev/get/contest_config?time='.(time()*1000)));
//        dd((new ApiHash('t+m:*meo6h}b?{~','*[Py49<>n@-VYr1'))->encrypt('dev/get/user_field?time='.(time()*1000)));
        $data_view = [
            'html_type_list' => $this->html_type_list,
            'type' => $this->type,
            'data_type' => $this->data_type
        ];
        return view('CONTEST-CONTEST::modules.contest.user_field.create', $data_view);
    }

    public function delete(Request $request)
    {
        $field_id = $request->input('field_id');
        $field = $this->field->find($field_id);

        if (null != $field) {
            $this->field->delete($field_id);

            activity('contest_list')
                ->performedOn($field)
                ->withProperties($request->all())
                ->log('User: :causer.email - Delete contest - field_id: :properties.field_id, name: ' . $field->name);

            return redirect()->route('contest.contest.user_field.manage')->with('success', trans('contest-contest::language.messages.success.delete'));
        } else {
            return redirect()->route('contest.contest.user_field.manage')->with('error', trans('contest-contest::language.messages.error.delete'));
        }
    }

    public function manage()
    {
        return view('CONTEST-CONTEST::modules.contest.user_field.manage');
    }

    public function show(Request $request)
    {
        $field_id = $request->input('field_id');
        $field = $this->field->find($field_id);
        $data = [
            'contest' => $field,
            'domain' => Domain::all()->pluck('name','domain_id')
        ];

        return view('CONTEST-CONTEST::modules.contest.user_field.edit', $data);
    }

    public function update(Request $request)
    {
        $domains = Domain::all()->pluck('name','domain_id');
        $field_id = $request->input('field_id');

        $field = $this->field->find($field_id);
        $field->name = $request->name;
        $field->alias = str_slug($request->name);
        $field->domain_id = $request->domain;
        $field->domain_name = $domains[$request->domain];
        $field->db_mysql = $request->db_mysql;
        $field->db_mongo = $request->db_mongo;

        if ($field->save()) {

            activity('contest_list')
                ->performedOn($field)
                ->withProperties($request->all())
                ->log('User: :causer.email - Update contest - field_id: :properties.field_id, name: :properties.name');

            return redirect()->route('contest.contest.user_field.manage')->with('success', trans('contest-contest::language.messages.success.update'));
        } else {
            return redirect()->route('contest.contest.user_field.show', ['field_id' => $request->input('field_id')])->with('error', trans('contest-contest::language.messages.error.update'));
        }
    }

    public function getModalDelete(Request $request)
    {
        $model = 'contest';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'field_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $confirm_route = route('contest.contest.user_field.delete', ['field_id' => $request->input('field_id')]);
                return view('includes.modal_confirmation', compact('error', 'model', 'confirm_route'));
            } catch (GroupNotFoundException $e) {
                return view('includes.modal_confirmation', compact('error', 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }

    public function log(Request $request)
    {
        $model = 'user_field';
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
        return Datatables::of($this->field->findAll())
            ->addColumn('actions', function ($field) {
                $actions = '<a href=' . route('contest.contest.user_field.log', ['type' => 'contest', 'id' => $field->field_id]) . ' data-toggle="modal" data-target="#log"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="log contest"></i></a>
                        <a href=' . route('contest.contest.user_field.show', ['field_id' => $field->field_id]) . '><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="update contest"></i></a>
                        <a href=' . route('contest.contest.user_field.confirm-delete', ['field_id' => $field->field_id]) . ' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete contest"></i></a>';

                return $actions;
            })
            ->addIndexColumn()
            ->rawColumns(['actions'])
            ->make();
    }

    public function getList(){
        $fields = Contest::all();
        $res = [];
        $res['data'] = $fields;
        $res['status'] = true;
        return response()->json($res);
    }

    public function getContest(Request $request){
        $res = [
            'status' => false,
            'data' => [],
            'messages' => ''
        ];
        if(!empty($request->domain)){
            $field = $this->field->findByDomain($request->domain);
            if(!empty($field)){
                $res['status'] = true;
                $res['data'] = $field;
            }
            else{
                $res['messages'] = 'Không có dữ liệu';
            }
        }
        else{
            $res['messages'] = 'no param';
        }
        return response()->json($res);
    }

    public function getApi(Request $request)
    {
        $hash = new ApiHash();
        if(!empty($request->data)) {
            try {
                $data = $hash->decrypt($request->data);
//                $route = 'http://cuocthi.vnedutech.vn/admin/api/'.$data;
                $route = config('app.url').'/admin/api/'.$data;
                return file_get_contents($route);
            }
            catch (\Exception $e) {
                echo "<pre>";print_r($e->getMessage());echo "</pre>";die;
            }
        }
    }

    public function getAllField(){
        $res = [
            'status' => false,
            'data' => null,
            'messages' => null
        ];
        $data = UserField::all();
        if(!empty($data)){
            foreach ($data as $key => $value){
                if(!empty($value->data_view)){
                    $data[$key]->data_view = json_decode($value->data_view,true);
                }
            }
            $res['status'] = true;
            $res['data'] = $data;
        }
        else{
            $res['messages'] = 'Không có dữ liệu';
        }
        return response()->json($res);
    }

    public function getConfig(){
        $res = [
            'status' => true,
            'data' => [
                'html_type_list' => $this->html_type_list,
                'type' => $this->type
            ],
            'messages' => null
        ];
        return response()->json($res);
    }

    public function getDataApi(Request $request){
        if(!empty($request->url)){
            return file_get_contents($request->url);
        }
    }
}
