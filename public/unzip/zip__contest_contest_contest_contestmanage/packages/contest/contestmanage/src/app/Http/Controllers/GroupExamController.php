<?php

namespace Contest\Contestmanage\App\Http\Controllers;

use Contest\Contestmanage\App\Models\ContestRound;
use Contest\Contestmanage\App\Models\GroupExam;
use Contest\Contestmanage\App\Models\GroupExamCandidate;
use Contest\Contestmanage\App\Repositories\GroupExamCandidateRepository;
use Contest\Contestmanage\App\Repositories\GroupExamRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Illuminate\Support\Facades\Schema;
use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator;

class GroupExamController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );

    public function __construct(GroupExamRepository $groupExamRepository, GroupExamCandidateRepository $groupExamCandidateRepository)
    {
        parent::__construct();
        $this->groupExam = $groupExamRepository;
        $this->groupExamCandidate = $groupExamCandidateRepository;
    }

    public function add(Request $request)
    {
        $group_exam = new GroupExam();
        $group_exam->name = $request->name;
        $group_exam->description = $request->description;
        $group_exam->round_id = $request->round;
        try{
            $group_exam->save();
            activity('group_exam')
                ->performedOn($group_exam)
                ->withProperties($request->all())
                ->log('User: :causer.email - Add cardProduct - name: :properties.name, product_id: ' . $group_exam->product_id);

            return redirect()->route('contest.contestmanage.group_exam.manage')->with('success', trans('contest-contestmanage::language.messages.success.create'));
        }
       catch(\Exception $e) {
            return redirect()->route('contest.contestmanage.group_exam.manage')->with('error', trans('contest-contestmanage::language.messages.error.create'));
        }

    }

    public function create()
    {
        $data_view = [
            'round' => ContestRound::all()->pluck('display_name','round_id')
        ];
        return view('CONTEST-CONTESTMANAGE::modules.contestmanage.group_exam.create', $data_view);
    }

    public function delete(Request $request)
    {
        $product_id = $request->input('product_id');
        $group_exam = $this->cardProduct->find($product_id);

        if (null != $group_exam) {
            $this->cardProduct->delete($product_id);

            activity('group_exam')
                ->performedOn($group_exam)
                ->withProperties($request->all())
                ->log('User: :causer.email - Delete cardProduct - product_id: :properties.product_id, name: ' . $group_exam->product_name);

            return redirect()->route('contest.contestmanage.group_exam.manage')->with('success', trans('contest-contestmanage::language.messages.success.delete'));
        } else {
            return redirect()->route('contest.contestmanage.group_exam.manage')->with('error', trans('contest-contestmanage::language.messages.error.delete'));
        }
    }

    public function manage()
    {
        $data_view = [
            'round' => ContestRound::all()->pluck('display_name','round_id')
        ];
        return view('CONTEST-CONTESTMANAGE::modules.contestmanage.group_exam.manage', $data_view);
    }

    public function show(Request $request)
    {
        $group_exam = $this->groupExam->find($request->group_exam_id);
        $data = [
            'group_exam' => $group_exam,
            'round' => ContestRound::all()->pluck('display_name','round_id')
        ];

        return view('CONTEST-CONTESTMANAGE::modules.contestmanage.group_exam.edit', $data);
    }

    public function update(Request $request)
    {
        $group_exam = $this->groupExam->find($request->group_exam_id);
        $group_exam->name = $request->name;
        $group_exam->description = $request->description;
        $group_exam->round_id = $request->round;
        if ($group_exam->update()) {

            activity('group_exam')
                ->performedOn($group_exam)
                ->withProperties($request->all())
                ->log('User: :causer.email - Update group_exam - group_exam_id: :properties.group_exam_id, name: :properties.name');

            return redirect()->route('contest.contestmanage.group_exam.manage')->with('success', trans('contest-contestmanage::language.messages.success.update'));
        } else {
            return redirect()->route('contest.contestmanage.group_exam.show', ['product_id' => $request->input('product_id')])->with('error', trans('contest-contestmanage::language.messages.error.update'));
        }
    }

    public function getModalDelete(Request $request)
    {
        $model = 'group_exam';
        $tittle='Xác nhận xóa';
        $type=$this->cardProduct->find($request->input('product_id'));
        $content='Bạn có chắc chắn muốn xóa loại: '.$type->product_name.'?';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $confirm_route = route('contest.contestmanage.group_exam.delete', ['product_id' => $request->input('product_id')]);
                return view('CONTEST-CONTESTMANAGE::modules.contestmanage.includes.modal_confirmation', compact('error','tittle','content', 'model', 'confirm_route'));
            } catch (GroupNotFoundException $e) {
                return view('includes.modal_confirmation', compact('error', 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }

    public function log(Request $request)
    {
        $model = 'group_exam';
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
        return Datatables::of($this->groupExam->findAll())
            ->addColumn('actions', function ($group_exam) {
                $actions = '<a href=' . route('contest.contestmanage.group_exam.log', ['type' => 'group_exam', 'id' => $group_exam->group_exam_id]) . ' data-toggle="modal" data-target="#log"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="log group_exam"></i></a>
                <a href=' . route('contest.contestmanage.group_exam.list_candidate', ['group_exam_id' => $group_exam->group_exam_id]) . '><i class="livicon" data-name="list" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="list candidate"></i></a>
                <a href=' . route('contest.contestmanage.group_exam.show', ['group_exam_id' => $group_exam->group_exam_id]) . '><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="update group_exam"></i></a>
                <a href=' . route('contest.contestmanage.group_exam.confirm-delete', ['group_exam_id' => $group_exam->group_exam_id]) . ' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete group_exam"></i></a>';

                return $actions;
            })
            ->rawColumns(['actions'])
            ->make();
    }
    public function listCandidate(Request $request){
        if(!empty($request->group_exam_id)){
            $data_view = [
                'group_exam' => $this->groupExam->find($request->group_exam_id)
            ];
            return view('CONTEST-CONTESTMANAGE::modules.contestmanage.group_exam.list_candidate', $data_view);
        }
    }

     public function getListCandidate(Request $request){
        if(!empty($request->group_exam_id)){
            $data_view = [
                'group_exam_id' =>$request->group_exam_id
            ];
            $html = view('CONTEST-CONTESTMANAGE::modules.contestmanage.includes.list_candidate', $data_view)->render();
            return response()->json($html);
        }
    }

    public function dataCandidate(Request $request){
        $group_exam_id = $request->group_exam_id;
        $start = (int)$request->start;
        $length = (int)$request->length;
        return Datatables::of($this->groupExamCandidate->getData($group_exam_id,$start, $length))
            ->setTotalRecords($this->groupExamCandidate->countAll($group_exam_id))
            ->editColumn('name', function ($group_exam_candidate){
                return $group_exam_candidate->member->name;
            })
            ->editColumn('gender', function ($group_exam_candidate){
                if($group_exam_candidate->member->gender == 'male'){
                    return 'Nam';
                }
                else{
                    return 'Nữ';
                }
            })
            ->editColumn('city', function ($group_exam_candidate){
                return $group_exam_candidate->member->city_name;
            })
            ->editColumn('district', function ($group_exam_candidate){
                return $group_exam_candidate->member->district_name;
            })
            ->editColumn('school', function ($group_exam_candidate){
                return $group_exam_candidate->member->school_name;
            })
            ->addColumn('actions', function ($group_exam_candidate) {
                $actions = '';
//                <a href=' . route('contest.contestmanage.group_exam.list_candidate', ['group_exam_id' => $group_exam->group_exam_id]) . '><i class="livicon" data-name="list" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="list candidate"></i></a>
//                <a href=' . route('contest.contestmanage.group_exam.show', ['group_exam_id' => $group_exam->group_exam_id]) . '><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="update group_exam"></i></a>
//                <a href=' . route('contest.contestmanage.group_exam.confirm-delete', ['group_exam_id' => $group_exam->group_exam_id]) . ' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete group_exam"></i></a>';

                return $actions;
            })
            ->rawColumns(['actions','name', 'gender', 'city' , 'district', 'school'])
            ->make();
    }

    public function addCandidate(Request $request){
        $group_exam = GroupExam::find($request->group_exam_id);
        if(!empty($group_exam->list_candidate)){
            $list = json_decode($group_exam->list_candidate,true);
        }
        else{
            $list = [];
        }
        $list[] = $request->member_id;
        $group_exam->list_candidate = json_encode($list);
        $group_exam_candidate = new GroupExamCandidate();
        $group_exam_candidate->group_exam_id = $request->group_exam_id;
        $group_exam_candidate->member_id = $request->member_id;
        try{
            $group_exam->update();
            $group_exam_candidate->save();
            $res = [
                'status' => true,
            ];
            return response()->json($res);
        }
        catch (\Exception $e){
            $res = [
                'status' => false,
            ];
            return response()->json($res);
        }
    }


}