<?php

namespace Contest\Contestmanage\App\Http\Controllers;

use Adtech\Application\Cms\Controllers\Controller as Controller;
use Contest\Contestmanage\App\ApiHash;
use Contest\Contestmanage\App\Models\ContestTarget;
use Contest\Contestmanage\App\Repositories\ContestTargetRepository;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Validator;

class ContestTargetController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric' => "Phải là số"
    );

    public function __construct(ContestTargetRepository $targetRepository)
    {
        parent::__construct();
        $this->target = $targetRepository;
    }

    public function show(Request $request)
    {
        $city = [];
        if(empty($target)){
            $target = new ContestTarget();
            $target->save();
        }
        $city_list = file_get_contents('http://cuocthi.vnedutech.vn/admin/vne/getprovince');
        if(!empty($city_list)){
            $city_list = json_decode($city_list,true);
            $arr_city = $city_list['data'];
            foreach ($arr_city as $key => $value){
                $city[$value['_id']] = $value['province'];
            }
        }

        $data = [
            'target' => $target,
            'city' => $city,
            'gender' => [
                'all' => "Tất cả",
                'male' => "Nam",
                'fermale' => 'Nữ'
            ],

        ];
        return view('CONTEST-CONTESTMANAGE::modules.contestmanage.contest_target.edit', $data);
    }

    public function getAdministrativeData(Request $request){

        if(!empty($request->type)){
            if($request->type == 'district'){
                if(!empty($request->city_id)){
                    $res = json_decode(file_get_contents('http://cuocthi.vnedutech.vn/admin/vne/getdistricts/' . $request->city_id));
                }
            }
        }
        return response()->json($res);
    }


    public function update(Request $request)
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

            activity('target')
                ->performedOn($season)
                ->withProperties($request->all())
                ->log('User: :causer.email - Update season - product_id: :properties.season_id, name: :properties.name');

            return redirect()->route('contest.contestmanage.target.manage')->with('success', trans('contest-contestmanage::language.messages.success.update'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
//            return redirect()->back()->with('error', trans('contest-contestmanage::language.messages.error.update'));
        }
    }


    public function log(Request $request)
    {
        $model = 'target';
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

}