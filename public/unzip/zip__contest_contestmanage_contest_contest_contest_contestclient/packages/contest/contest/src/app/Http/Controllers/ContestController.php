<?php

namespace Contest\Contest\App\Http\Controllers;

use Adtech\Core\App\Models\Domain;
use Contest\Contest\App\Models\Contest;
use Contest\Contest\App\ApiHash;
use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Contest\Contest\App\Repositories\ContestRepository;
use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator;

class ContestController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );

    public function __construct(ContestRepository $contestRepository)
    {
        parent::__construct();
        $this->contest = $contestRepository;
    }

    public function add(Request $request)
    {
        $domains = Domain::all()->pluck('name','domain_id');
        $contest = new Contest();
        $contest->name = $request->name;
        $contest->alias = str_slug($request->name);
        $contest->domain_id = $request->domain;
        $contest->domain_name = $domains[$request->domain];
        $contest->db_mysql = $request->db_mysql;
        $contest->db_mongo = $request->db_mongo;
        $contest->save();

        if ($contest->contest_id) {

            activity('contest_list')
                ->performedOn($contest)
                ->withProperties($request->all())
                ->log('User: :causer.email - Add contest - name: :properties.name, contest_id: ' . $contest->contest_id);

            return redirect()->route('contest.contest.contest_list.manage')->with('success', trans('contest-contest::language.messages.success.create'));
        } else {
            return redirect()->route('contest.contest.contest_list.manage')->with('error', trans('contest-contest::language.messages.error.create'));
        }
    }

    public function create()
    {
        $data_view = [
            'domain' => Domain::all()->pluck('name','domain_id')
        ];
        return view('CONTEST-CONTEST::modules.contest.contest.create', $data_view);
    }

    public function delete(Request $request)
    {
        $contest_id = $request->input('contest_id');
        $contest = $this->contest->find($contest_id);

        if (null != $contest) {
            $this->contest->delete($contest_id);

            activity('contest_list')
                ->performedOn($contest)
                ->withProperties($request->all())
                ->log('User: :causer.email - Delete contest - contest_id: :properties.contest_id, name: ' . $contest->name);

            return redirect()->route('contest.contest.contest_list.manage')->with('success', trans('contest-contest::language.messages.success.delete'));
        } else {
            return redirect()->route('contest.contest.contest_list.manage')->with('error', trans('contest-contest::language.messages.error.delete'));
        }
    }

    public function manage()
    {
        return view('CONTEST-CONTEST::modules.contest.contest.manage');
    }

    public function show(Request $request)
    {
        $contest_id = $request->input('contest_id');
        $contest = $this->contest->find($contest_id);
        $data = [
            'contest' => $contest,
            'domain' => Domain::all()->pluck('name','domain_id')
        ];

        return view('CONTEST-CONTEST::modules.contest.contest.edit', $data);
    }

    public function update(Request $request)
    {
        $domains = Domain::all()->pluck('name','domain_id');
        $contest_id = $request->input('contest_id');

        $contest = $this->contest->find($contest_id);
        $contest->name = $request->name;
        $contest->alias = str_slug($request->name);
        $contest->domain_id = $request->domain;
        $contest->domain_name = $domains[$request->domain];
        $contest->db_mysql = $request->db_mysql;
        $contest->db_mongo = $request->db_mongo;

        if ($contest->save()) {

            activity('contest_list')
                ->performedOn($contest)
                ->withProperties($request->all())
                ->log('User: :causer.email - Update contest - contest_id: :properties.contest_id, name: :properties.name');

            return redirect()->route('contest.contest.contest_list.manage')->with('success', trans('contest-contest::language.messages.success.update'));
        } else {
            return redirect()->route('contest.contest.contest_list.show', ['contest_id' => $request->input('contest_id')])->with('error', trans('contest-contest::language.messages.error.update'));
        }
    }

    public function getModalDelete(Request $request)
    {
        $model = 'contest';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'contest_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $confirm_route = route('contest.contest.contest_list.delete', ['contest_id' => $request->input('contest_id')]);
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
        $model = 'contest';
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
        return Datatables::of($this->contest->findAll())
            ->addColumn('actions', function ($contest) {
                $actions = '<a href=' . route('contest.contest.contest_list.log', ['type' => 'contest', 'id' => $contest->contest_id]) . ' data-toggle="modal" data-target="#log"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="log contest"></i></a>
                        <a href=' . route('contest.contest.contest_list.show', ['contest_id' => $contest->contest_id]) . '><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="update contest"></i></a>
                        <a href=' . route('contest.contest.contest_list.confirm-delete', ['contest_id' => $contest->contest_id]) . ' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete contest"></i></a>';

                return $actions;
            })
            ->addIndexColumn()
            ->rawColumns(['actions'])
            ->make();
    }

    public function getList(){
        $contests = Contest::all();
        $res = [];
        $res['data'] = $contests;
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
            $contest = $this->contest->findByDomain($request->domain);
            if(!empty($contest)){
                $res['status'] = true;
                $res['data'] = $contest;
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
}
