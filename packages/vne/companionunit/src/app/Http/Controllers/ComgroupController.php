<?php

namespace Vne\Companionunit\App\Http\Controllers;

use Illuminate\Http\Request;
use Vne\Companionunit\App\Http\Requests\ComgroupRequest;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Vne\Companionunit\App\Repositories\ComgroupRepository;
use Vne\Companionunit\App\Models\Comgroup;
use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator;

class ComgroupController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric' => "Phải là số"
    );

    public function __construct(ComgroupRepository $comgroupRepository)
    {
        parent::__construct();
        $this->comgroup = $comgroupRepository;
    }

    public function add(ComgroupRequest $request)
    {
        try {
            $comgroup = new Comgroup($request->all());
            $comgroup->comgroup = $request->input('comgroup');
            $comgroup->save();
        } catch (\Exception $e) {
            return redirect()->route('vne.comgroup.create')->with('error', $e->getMessage());
        }
        if ($comgroup->id) {
            activity('comgroup')
                ->performedOn($comgroup)
                ->withProperties($request->all())
                ->log('User: :causer.email - Add Nhóm Đơn Vị - name: :properties.name, id: ' . $comgroup->id);

            return redirect()->route('vne.comgroup.manage')->with('success', trans('vne-companionunit::language.messages.success.create'));
        } else {
            return redirect()->route('vne.comgroup.manage')->with('error', trans('vne-companionunit::language.messages.error.create'));
        }
    }

    public function create()
    {
        return view('VNE-COMPANIONUNIT::modules.companionunit.group.create');
    }

    public function delete(Request $request)
    {
        $id = $request->input('id');
        $comgroup = $this->comgroup->findOrFail($id);

        if (null != $comgroup) {
            $this->comgroup->delete($id);

            activity('comgroup')
                ->performedOn($comgroup)
                ->withProperties($request->all())
                ->log('User: :causer.email - Delete Nhóm Đơn Vị - id: :properties.id, name: ' . $comgroup->comgroup);

            return redirect()->route('vne.comgroup.manage')->with('success', trans('vne-companionunit::language.messages.success.delete'));
        } else {
            return redirect()->route('vne.comgroup.manage')->with('error', trans('vne-companionunit::language.messages.error.delete'));
        }
    }

    public function manage()
    {
        return view('VNE-COMPANIONUNIT::modules.companionunit.group.manage');
    }

    public function show(Request $request)
    {
        $id = $request->input('id');
        $comgroup = $this->comgroup->findOrFail($id);
        $data = [
            'comgroup' => $comgroup
        ];

        return view('VNE-COMPANIONUNIT::modules.companionunit.group.edit', $data);
    }

    public function update(ComgroupRequest $request)
    {
        $id = $request->input('id');
        $comgroup = $this->comgroup->findOrFail($id);
        try {
            $comgroup->comgroup = $request->input('comgroup');
            $comgroup->save();
        } catch (\Exception $e) {
            return redirect()->route('vne.comgroup.create')->with('error', $e->getMessage());
        }
        if ($comgroup->id) {
            activity('comgroup')
                ->performedOn($comgroup)
                ->withProperties($request->all())
                ->log('User: :causer.email - Update Nhóm Đơn Vị - name: :properties.name, id: ' . $comgroup->id);
            return redirect()->route('vne.comgroup.manage')->with('success', trans('vne-companionunit::language.messages.success.update'));
        } else {
            return redirect()->route('vne.comgroup.show', ['id' => $request->input('id')])->with('error', trans('vne-companionunit::language.messages.error.update'));
        }
    }

    public function getModalDelete(Request $request)
    {
        $model = 'comgroup';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $confirm_route = route('vne.comgroup.delete', ['id' => $request->input('id')]);
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
        $model = 'comgroup';
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
        return Datatables::of($this->comgroup->findAll())
            ->addColumn('actions', function ($comgroup) {
                $actions = '<a href=' . route('vne.comgroup.log', ['type' => 'comgroup', 'id' => $comgroup->id]) . ' data-toggle="modal" data-target="#log"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="log comgroup"></i></a>
                        <a href=' . route('vne.comgroup.show', ['id' => $comgroup->id]) . '><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="update comgroup"></i></a>
                        <a href=' . route('vne.comgroup.confirm-delete', ['id' => $comgroup->id]) . ' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete comgroup"></i></a>';
                return $actions;
            })
            ->addIndexColumn()
            ->rawColumns(['actions'])
            ->make();
    }
}
