<?php

namespace Contest\Contestmanage\App\Http\Controllers;

use Contest\Contestmanage\App\ContestEnvironment;
use Contest\Contestmanage\App\Http\Requests\RoundRequest;
use Contest\Contestmanage\App\Models\ContestRound;
use Contest\Contestmanage\App\Models\ContestSetting;
use Contest\Contestmanage\App\Models\RoundConfig;
use Contest\Contestmanage\App\Repositories\ContestRoundRepository;
use Contest\Contestmanage\App\Repositories\ContestSettingRepository;
use Contest\Contestmanage\App\Repositories\RoundConfigRepository;
use function foo\func;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Illuminate\Support\Facades\Schema;
use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator;

class ContestRoundController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );
    private $type = ['online' => 'Online', 'offline' => 'Offline'];

    public function __construct( ContestRoundRepository $contestRoundRepository, RoundConfigRepository $roundConfigRepository, ContestSettingRepository $contestSettingRepository)
    {
        parent::__construct();
        $this->contestRound = $contestRoundRepository;
        $this->env = new ContestEnvironment();
        $this->roundConfig = $roundConfigRepository;
        $this->setting = $contestSettingRepository;
    }

    public function add(RoundRequest $request)
    {
        $round = new ContestRound();
        $round->display_name = base64_encode($request->name);
        $round->round_name = str_slug($request->name);
        $round->description = base64_encode($request->description);
        $round->rule = base64_encode($request->rules);
        $round->end_notify = base64_encode($request->end_notify);
        $round->round_condition = $request->round_condition;
        $round->round_point_method = $request->round_point_method;
        $start_date = date_create_from_format('d-m-Y H:i', $request->start_date);
        $end_date = date_create_from_format('d-m-Y H:i', $request->end_date);
        $round->start_date = $start_date;
        $round->end_date = $end_date;
        $round->order = $request->order;
        $round->status = '1';
        try{
            $round->save();
            if(!empty($request->environment)){
                $config_arr = [];
                foreach ( $request->environment as $key=>$value){
                    $config_arr[] = [
                        'environment' => $value,
                        'config_id' => $request->config_id[$key],
                        'round_id' => $round->round_id,
                        'success' => '1'
                    ];
                }
                RoundConfig::insert($config_arr);
            }
            activity('contest_round')
                ->performedOn($round)
                ->withProperties($request->all())
                ->log('User: :causer.email - Add round - name: :properties.name, round_id: ' . $round->round_id);

            return redirect()->route('contest.contestmanage.contest_round.manage')->with('success', trans('contest-contestmanage::language.messages.success.create'));
        }
        catch(\Exception $e) {
            echo "<pre>";print_r($e->getMessage());echo "</pre>";die;
            return redirect()->route('contest.contestmanage.contest_round.manage')->with('error', trans('contest-contestmanage::language.messages.error.create'));
        }
    }

    public function create()
    {
        $data_view = [
            'type' => $this->type,
            'environment' => $this->env->getEnvironment(),
            'option' => $this->env->getOption(),
            'round_type' => $this->env->getRoundType(),
            'round_condition' => $this->setting->getSettingData('round_condition'),
            'round_point_method' => $this->setting->getSettingData('round_point_method')
        ];
        return view('CONTEST-CONTESTMANAGE::modules.contestmanage.contest_round.create', $data_view);
    }

    public function delete(Request $request)
    {
        $product_id = $request->input('product_id');
        $card_product = $this->contestRound->find($product_id);

        if (null != $card_product) {
            $this->contestRound->delete($product_id);

            activity('contest_round')
                ->performedOn($card_product)
                ->withProperties($request->all())
                ->log('User: :causer.email - Delete cardProduct - product_id: :properties.product_id, name: ' . $card_product->product_name);

            return redirect()->route('contest.contestmanage.contest_round.manage')->with('success', trans('contest-contestmanage::language.messages.success.delete'));
        } else {
            return redirect()->route('contest.contestmanage.contest_round.manage')->with('error', trans('contest-contestmanage::language.messages.error.delete'));
        }
    }

    public function manage()
    {
        $data_view = [
            'round_type' => $this->env->getRoundType()
        ];
        return view('CONTEST-CONTESTMANAGE::modules.contestmanage.contest_round.manage', $data_view);
    }

    public function show(Request $request)
    {
        $round = $this->contestRound->find($request->round_id);
        if(!empty($round)){
            $start_date = date_create_from_format('Y-m-d H:i:s', $round->start_date);
            $end_date = date_create_from_format('Y-m-d H:i:s', $round->end_date);
            $round->start_date = $start_date->format('d-m-Y H:i');
            $round->end_date = $end_date->format('d-m-Y H:i');
        }
        $data = [
            'round' => $round,
            'type' => $this->type,
            'environment' => $this->env->getEnvironment(),
            'option' => $this->env->getOption(),
            'round_type' => $this->env->getRoundType(),
            'round_config' => $this->roundConfig->findByRound($request->round_id),
            'round_condition' => $this->setting->getSettingData('round_condition'),
            'round_point_method' => $this->setting->getSettingData('round_point_method')
        ];

        return view('CONTEST-CONTESTMANAGE::modules.contestmanage.contest_round.edit', $data);
    }

    public function update(RoundRequest $request)
    {
        $round = $this->contestRound->find($request->round_id);
        $round->display_name = base64_encode($request->name);
        $round->round_name = str_slug($request->name);
        $round->description = base64_encode($request->description);
        $round->rule = base64_encode($request->rules);
        $round->end_notify = base64_encode($request->end_notify);
        $round->round_condition = $request->round_condition;
        $round->round_point_method = $request->round_point_method;
        $start_date = date_create_from_format('d-m-Y H:i', $request->start_date);
        $end_date = date_create_from_format('d-m-Y H:i', $request->end_date);
        $round->start_date = $start_date;
        $round->end_date = $end_date;
        $round->order = $request->order;
        $round->status = '1';
        try{
            $round->save();
            RoundConfig::where('round_id', $request->round_id)->delete();
            if(!empty($request->environment)){
                $config_arr = [];
                foreach ( $request->environment as $key=>$value){
                    $config_arr[] = [
                        'environment' => $value,
                        'config_id' => $request->config_id[$key],
                        'round_id' => $round->round_id,
                        'success' => '1'
                    ];
                }
                RoundConfig::insert($config_arr);
            }
            activity('contest_round')
                ->performedOn($round)
                ->withProperties($request->all())
                ->log('User: :causer.email - Update round - round_id: :properties.round_id, name: :properties.display_name');

            return redirect()->route('contest.contestmanage.contest_round.manage')->with('success', trans('contest-contestmanage::language.messages.success.update'));
        }
        catch (\Exception $e) {
            return redirect()->back()->with('error', trans('contest-contestmanage::language.messages.error.update'));
        }
    }

    public function getModalDelete(Request $request)
    {
        $model = 'contest_round';
        $tittle='Xác nhận xóa';
        $type=$this->contestRound->find($request->input('product_id'));
        $content='Bạn có chắc chắn muốn xóa loại: '.$type->product_name.'?';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $confirm_route = route('contest.contestmanage.contest_round.delete', ['product_id' => $request->input('product_id')]);
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
        $model = 'contest_round';
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
        return Datatables::of($this->contestRound->findAll())
            ->editColumn('display_name', function ($round){
                if(!empty($round->display_name)){
                    return base64_decode($round->display_name);
                }
                else{
                    return '';
                }
            })
            ->addColumn('actions', function ($round) {
                $actions = '<a href=' . route('contest.contestmanage.contest_round.log', ['type' => 'contest_round', 'id' => $round->round_id]) . ' data-toggle="modal" data-target="#log"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="log contest_round"></i></a>
                       <a href=' . route('contest.contestmanage.contest_round.show', ['round_id' => $round->round_id]) . '><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="update contest_round"></i></a>
                <a href=' . route('contest.contestmanage.contest_round.confirm-delete', ['round_id' => $round->round_id]) . ' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete contest_round"></i></a>';

                return $actions;
            })
            ->rawColumns(['actions'])
            ->make();
    }

    public function getConfig(Request $request){
        return $this->roundConfig->findByRound($request->round_id);
    }


}