<?php

namespace Contest\Contestmanage\App\Http\Controllers;

use Adtech\Application\Cms\Controllers\Controller as Controller;
use Contest\Contestmanage\App\ApiHash;
use Contest\Contestmanage\App\ContestEnvironment;
use Contest\Contestmanage\App\Http\Requests\SeasonRequest;
use Contest\Contestmanage\App\Models\ContestSeason;
use Contest\Contestmanage\App\Models\SeasonConfig;
use Contest\Contestmanage\App\Repositories\ContestConfigRepository;
use Contest\Contestmanage\App\Repositories\ContestSeasonRepository;
use Contest\Contestmanage\App\Repositories\SeasonConfigRepository;
use Dhcd\Contest\App\Repositories\ContestRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Jenssegers\Mongodb\Schema\Blueprint;
use Spatie\Activitylog\Models\Activity;
use Validator;
use Yajra\Datatables\Datatables;

class ContestSeasonController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric' => "Phải là số"
    );

    public function __construct(SeasonConfigRepository $seasonConfigRepository, ContestSeasonRepository $contestSeasonRepository, ContestConfigRepository $contestConfigRepository)
    {
        parent::__construct();
        $this->contestSeason = $contestSeasonRepository;
        $this->seasonConfig = $seasonConfigRepository;
        $this->config = $contestConfigRepository;
        $this->env = new ContestEnvironment();
    }


    public function add(SeasonRequest $request)
    {
        $season = new ContestSeason();
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
        $season->status = '0';
        try {
            $season->save();
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
            activity('contest_season')
                ->performedOn($season)
                ->withProperties($request->all())
                ->log('User: :causer.email - Add season - name: :properties.name, season_id: ' . $season->season_id);

            return redirect()->route('contest.contestmanage.contest_season.manage')->with('success', trans('contest-contestmanage::language.messages.success.create'));
        } catch (\Exception $e) {
            return redirect()->route('contest.contestmanage.contest_season.manage')->with('error', trans('contest-contestmanage::language.messages.error.create'));
        }
    }

    public function create()
    {
        $data_view = [
            'environment' => $this->env->getEnvironment()
        ];
        return view('CONTEST-CONTESTMANAGE::modules.contestmanage.contest_season.create', $data_view);
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

            return redirect()->route('contest.contestmanage.contest_season.manage')->with('success', trans('contest-contestmanage::language.messages.success.delete'));
        } else {
            return redirect()->route('contest.contestmanage.contest_season.manage')->with('error', trans('contest-contestmanage::language.messages.error.delete'));
        }
    }

    public function manage()
    {

        return view('CONTEST-CONTESTMANAGE::modules.contestmanage.contest_season.manage');
    }

    public function show(Request $request)
    {
        $season = $this->contestSeason->find($request->season_id);
        $data = [
            'season' => $season,
            'environment' => $this->env->getEnvironment(),
            'season_config' => $this->seasonConfig->findBySeason($request->season_id)
        ];

        return view('CONTEST-CONTESTMANAGE::modules.contestmanage.contest_season.edit', $data);
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

            activity('contest_season')
                ->performedOn($season)
                ->withProperties($request->all())
                ->log('User: :causer.email - Update season - product_id: :properties.season_id, name: :properties.name');

            return redirect()->route('contest.contestmanage.contest_season.manage')->with('success', trans('contest-contestmanage::language.messages.success.update'));
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
                $confirm_route = route('contest.contestmanage.contest_season.delete', ['product_id' => $request->input('product_id')]);
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
        $model = 'contest_season';
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
        return Datatables::of($this->contestSeason->findAll())
            ->addColumn('actions', function ($season) {
                $actions = '';
                if ($season->status == '0') {
                    $actions .= '<a href="' . route('contest.contestmanage.contest_season.change', ['season_id' => $season->season_id]) . '" ><i class="livicon" data-name="circle" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="active season"></i></a>';
                }
                $actions .= '<a href=' . route('contest.contestmanage.contest_season.log', ['type' => 'contest_season', 'id' => $season->season_id]) . ' data-toggle="modal" data-target="#log"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="log season"></i></a>                      
                <a href=' . route('contest.contestmanage.contest_season.show', ['season_id' => $season->season_id]) . '><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="update season"></i></a>
                <a href=' . route('contest.contestmanage.contest_season.confirm-delete', ['season_id' => $season->season_id]) . ' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete season"></i></a>';

                return $actions;
            })
            ->editColumn('status', function ($season) {
                if ($season->status == '-1') {
                    return '<span class="label label-default">Vô hiệu</span>';
                } elseif ($season->status == '1') {
                    return '<span class="label label-sm label-success">Đang kích hoạt</span>';
                } elseif ($season->status == '0') {
                    return '<span class="label label-warning">Mới</span>';
                } else{
                    return '<span class="label label-default">Đã lưu trữ</span>';
                }
            })
            ->rawColumns(['actions', 'status'])
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
        $new_season = $this->contestSeason->find($request->season_id);
        if(!empty($curr_season)){
            $info_name = 'users_exam_info_' . $curr_season->number;
            $result_name = 'contest_exam_result_' . $curr_season->number;
            if(!empty($new_season) && $new_season->status == '0'){
                try {
                    $db = config('database.connections.mongodb.database');
                    DB::connection('mongodb')->getMongoClient()->admin->command([
                        'renameCollection' => "{$db}.users_exam_info",
                        'to' => "{$db}." . $info_name,
                    ]);
                    DB::connection('mongodb')->getMongoClient()->admin->command([
                        'renameCollection' => "{$db}.contest_exam_result",
                        'to' => "{$db}." . $result_name,
                    ]);
                    Schema::connection('mongodb')->create('users_exam_info', function (Blueprint $table) {});
                    Schema::connection('mongodb')->create('contest_exam_result', function (Blueprint $table) {});
                    $curr_season->db_info_name = $info_name;
                    $curr_season->db_result_name = $result_name;
                    $curr_season->status = '2';
                    $curr_season->update();

                    $new_season->status = '1';
                    $new_season->db_info_name = 'users_exam_info';
                    $new_season->db_result_name = 'contest_exam_result';
                    $new_season->update();
                    return redirect()->route('contest.contestmanage.contest_season.manage')->with('success', trans('contest-contestmanage::language.messages.success.update'));
                } catch (\Exception $e) {
                    echo "<pre>";
                    print_r($e->getMessage());
                    echo "</pre>";
                    die;
                }

            }
            else{
                return redirect()->route('contest.contestmanage.contest_season.manage')->with('error', trans('contest-contestmanage::language.messages.error.change'));
            }
        }
        else{
            if(!empty($new_season) && $new_season->status == '0'){
                $new_season->status = '1';
                $new_season->db_info_name = 'users_exam_info';
                $new_season->db_result_name = 'contest_exam_result';
                $new_season->update();
                return redirect()->route('contest.contestmanage.contest_season.manage')->with('success', trans('contest-contestmanage::language.messages.success.update'));
            }
        }
    }

}