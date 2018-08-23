<?php

namespace Dhcd\Member\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Dhcd\Member\App\Repositories\PositionRepository;
use Dhcd\Member\App\Models\Position;
use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator,DateTime;

class PositionMemberController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );

    public function __construct(PositionRepository $positionRepository)
    {
        parent::__construct();
        $this->position = $positionRepository;
    }

    public function manage()
    {
        return view('DHCD-MEMBER::modules.member.position.manage');
    }

    public function create()
    {
        return view('DHCD-MEMBER::modules.member.position.create');
    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ], $this->messages);
        if (!$validator->fails()) {
            $positions = new Position();
            $positions->name = $request->input('name');
            $positions->alias = strtolower(preg_replace('([^a-zA-Z0-9])', '', self::stripUnicode($request->input('name'))));
            $positions->created_at = new DateTime();
            $positions->updated_at = new DateTime();

            if ($positions->save()) {

                activity('position')
                    ->performedOn($positions)
                    ->withProperties($request->all())
                    ->log('User: :causer.email - Add position - name: :properties.name, position_id: ' . $positions->position_id);

                return redirect()->route('dhcd.member.position.manage')->with('success', trans('dhcd-member::language.messages.success.create'));
            } else {
                return redirect()->route('dhcd.member.position.manage')->with('error', trans('dhcd-member::language.messages.error.create'));
            }
        } else {
            return $validator->messages();
        }
    }

    public function show(Request $request)
    {
        $position_id = $request->input('position_id');
        $position = $this->position->find($position_id);
        if($position==null){
            return redirect()->route('dhcd.member.position.manage')->with('error', trans('dhcd-member::language.messages.error.udpate')); 
        }
        $data = [
            'position' => $position
        ];

        return view('DHCD-MEMBER::modules.member.position.edit', $data);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'position_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            $position_id = $request->input('position_id');

            $position = $this->position->find($position_id);
            $position->name = $request->input('name');
            $position->alias = strtolower(preg_replace('([^a-zA-Z0-9])', '', self::stripUnicode($request->input('name'))));
            $position->updated_at = new DateTime();
            if ($position->save()) {

                activity('position')
                    ->performedOn($position)
                    ->withProperties($request->all())
                    ->log('User: :causer.email - Update position - position_id: :properties.position_id, name: :properties.name');

                return redirect()->route('dhcd.member.position.manage')->with('success', trans('dhcd-member::language.messages.success.update'));
            } else {
                return redirect()->route('dhcd.member.position.show', ['position_id' => $request->input('position_id')])->with('error', trans('dhcd-member::language.messages.error.update'));
            }
        } else {
            return $validator->messages();
        }
    }

    public function getModalDelete(Request $request)
    {
        $model = 'position';
        $type = 'delete';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'position_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $confirm_route = route('dhcd.member.position.delete', ['position_id' => $request->input('position_id')]);
                return view('DHCD-MEMBER::modules.member.modal.modal_confirmation', compact('error','type', 'model', 'confirm_route'));
            } catch (GroupNotFoundException $e) {
                return view('DHCD-MEMBER::modules.member.modal.modal_confirmation', compact('error','type', 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }

    public function delete(Request $request)
    {
        $position_id = $request->input('position_id');
        $position = $this->position->find($position_id);

        if (null != $position) {
            $this->position->delete($position_id);

            activity('position')
                ->performedOn($position)
                ->withProperties($request->all())
                ->log('User: :causer.email - Delete position - position_id: :properties.position_id, name: ' . $position->name);

            return redirect()->route('dhcd.member.position.manage')->with('success', trans('dhcd-member::language.messages.success.delete'));
        } else {
            return redirect()->route('dhcd.member.position.manage')->with('error', trans('dhcd-member::language.messages.error.delete'));
        }
    }

    public function log(Request $request)
    {
        $model = 'position';
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
                return view('DHCD-MEMBER::modules.member.modal.modal_table', compact('error', 'model', 'confirm_route', 'logs'));
            } catch (GroupNotFoundException $e) {
                return view('DHCD-MEMBER::modules.member.modal.modal_table', compact('error', 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }

    //Table Data to index page
    public function data()
    {   
        $positions = $this->position->all();
        return Datatables::of($positions)
            ->addIndexColumn()
            ->addColumn('actions', function ($positions) {
                $actions = '';
                if ($this->user->canAccess('dhcd.member.position.log')) {
                    $actions .= '<a href=' . route('dhcd.member.position.log', ['type' => 'position', 'id' => $positions->position_id]) . ' data-toggle="modal" data-target="#log"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="log position"></i></a>';
                }
                if ($this->user->canAccess('dhcd.member.position.show')) {
                    $actions .= '<a href=' . route('dhcd.member.position.show', ['position_id' => $positions->position_id]) . '><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="update position"></i></a>';
                }
                if ($this->user->canAccess('dhcd.member.position.confirm-delete')) {
                    $actions .= '<a href=' . route('dhcd.member.position.confirm-delete', ['position_id' => $positions->position_id]) . ' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete position"></i></a>';
                }
                return $actions;
            })
            ->rawColumns(['actions'])
            ->make();
    }
}
