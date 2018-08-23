<?php

namespace Dhcd\Sessionseat\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Dhcd\Sessionseat\App\Repositories\SessionseatRepository;
use Dhcd\Sessionseat\App\Models\Sessionseat;
use Dhcd\Sessionseat\App\Http\Requests\SessionseatRequest;
use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator;

class SessionseatController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );

    public function __construct(SessionseatRepository $sessionseatRepository)
    {
        parent::__construct();
        $this->sessionseat = $sessionseatRepository;
    }

    public function add(SessionseatRequest $request)
    {
        $sessionseat = new Sessionseat($request->all());
        $sessionseat->sessionseat_name = $request->input('sessionseat_name');
        $sessionseat->sessionseat_img = $request->input('sessionseat_img');

        $sessionseat->save();
        if ($sessionseat->sessionseat_id) {
            activity('sessionseat')
                ->performedOn($sessionseat)
                ->withProperties($request->all())
                ->log('User: :causer.email - Add Sessionseat - name: :properties.name, sessionseat_id: ' . $sessionseat->sessionseat_id);
            return redirect()->route('dhcd.sessionseat.manage')->with('success', trans('dhcd-sessionseat::language.messages.success.create'));
        } else {
            return redirect()->route('dhcd.sessionseat.manage')->with('error', trans('dhcd-sessionseat::language.messages.error.create'));
        }
    }

    public function create()
    {
        return view('DHCD-SESSIONSEAT::modules.sessionseat.create');
    }

    public function delete(SessionseatRequest $request)
    {
        $sessionseat_id = $request->input('sessionseat_id');
        $sessionseat = $this->sessionseat->find($sessionseat_id);
        if (null != $sessionseat) {
            $this->sessionseat->delete($sessionseat_id);
            activity('sessionseat')
                ->performedOn($sessionseat)
                ->withProperties($request->all())
                ->log('User: :causer.email - Delete sessionseat - sessionseat_id: :properties.sessionseat, name: ' . $sessionseat->sessionseat_name);
            return redirect()->route('dhcd.sessionseat.manage')->with('success', trans('dhcd-sessionseat::language.messages.success.delete'));
        } else {
            return redirect()->route('dhcd.sessionseat.manage')->with('error', trans('dhcd-sessionseat::language.messages.error.delete'));
        }
    }

    public function manage()
    {
        return view('DHCD-SESSIONSEAT::modules.sessionseat.manage');
    }

    public function show(SessionseatRequest $request)
    {
        $sessionseat_id = $request->input('sessionseat_id');
        $sessionseat = $this->sessionseat->find($sessionseat_id);
        if(null!=$sessionseat){
            $data = [
                'sessionseat' => $sessionseat
            ];
            return view('DHCD-SESSIONSEAT::modules.sessionseat.edit', $data);
        }
        return view('DHCD-SESSIONSEAT::modules.sessionseat.create');
    }

    public function update(SessionseatRequest $request)
    {
        $sessionseat_id = $request->input('sessionseat_id');
        $sessionseat = $this->sessionseat->find($sessionseat_id);
        if(null!=$sessionseat){
            $sessionseat->sessionseat_name = $request->input('sessionseat_name');
            $sessionseat->sessionseat_img = $request->input('sessionseat_img');
            if ($sessionseat->save()) {
                activity('sessionseat')
                    ->performedOn($sessionseat)
                    ->withProperties($request->all())
                    ->log('User: :causer.email - Update Sessionseat - sessionseat_id: :properties.sessionseat_id, name: :properties.sessionseat_name');
                return redirect()->route('dhcd.sessionseat.manage')->with('success', trans('dhcd-sessionseat::language.messages.success.update'));
            } else {
                return redirect()->route('dhcd.sessionseat.show', ['sessionseat_id' => $request->input('sessionseat_id')])->with('error', trans('dhcd-sessionseat::language.messages.error.update'));
            }
        }
        return view('DHCD-SESSIONSEAT::modules.sessionseat.create');

    }
    public function getModalDelete(SessionseatRequest $request)
    {
        $model = 'sessionseat';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'sessionseat_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $confirm_route = route('dhcd.sessionseat.delete', ['sessionseat_id' => $request->input('sessionseat_id')]);
                return view('includes.modal_confirmation', compact('error', 'model', 'confirm_route'));
            } catch (GroupNotFoundException $e) {
                return view('includes.modal_confirmation', compact('error', 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }
    public function log(SessionseatRequest $request)
    {
        $model = 'sessionseat';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'sessionseat_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $logs = Activity::where([
                    ['log_name', $model],
                    ['subject_id', $request->input('sessionseat_id')]
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
        return Datatables::of($this->sessionseat->findAll())
            ->editColumn('img',function ($sessionseat){
                $img = $sessionseat->sessionseat_img;
                return '<img src='.$img.' height="auto" width="200px">';
            })
            ->addColumn('actions', function ($sessionseat) {
                $actions = '';
                if($this->user->canAccess('dhcd.sessionseat.log')){
                    $actions .='<a href=' . route('dhcd.sessionseat.log', ['type' => 'sessionseat', 'sessionseat_id' => $sessionseat->sessionseat_id]) . ' data-toggle="modal" data-target="#log"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="log sessionseat"></i></a>';
                }
                if($this->user->canAccess('dhcd.sessionseat.show')){
                    $actions .='<a href=' . route('dhcd.sessionseat.show', ['sessionseat_id' => $sessionseat->sessionseat_id]) . '><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="update sessionseat"></i></a>';
                }
                if($this->user->canAccess('dhcd.sessionseat.confirm-delete')){
                    $actions .='<a href=' . route('dhcd.sessionseat.confirm-delete', ['sessionseat_id' => $sessionseat->sessionseat_id]) . ' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete sessionseat"></i></a>';
                }
                return $actions;
            })
            ->addIndexColumn()
            ->rawColumns(['actions','img'])
            ->make();
    }
}
