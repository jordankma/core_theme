<?php

namespace Vne\Companionunit\App\Http\Controllers;

use Illuminate\Http\Request;
use Vne\Companionunit\App\Http\Requests\CompanionunitRequest;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Vne\Companionunit\App\Repositories\ComunitRepository;
use Vne\Companionunit\App\Models\Companionunit;
use Vne\Companionunit\App\Models\Comgroup;
use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator;

class CompanionunitController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric' => "Phải là số"
    );

    public function __construct(ComunitRepository $ComunitRepository)
    {
        parent::__construct();
        $this->Comunit = $ComunitRepository;
    }

    public function add(CompanionunitRequest $request)
    {
        try {
            $Comunit = new Companionunit($request->all());
            $Comunit->comname = $request->input('comname');
            $Comunit->comlink = $request->input('comlink');
            $Comunit->comnote = $request->input('comnote');
            $Comunit->comtype = $request->input('comtype');
            $Comunit->img = $request->input('img');
            $Comunit->save();
        } catch (\Exception $e) {
            return redirect()->route('vne.companionunit.create')->with('error', $e->getMessage());
        }
        if ($Comunit->id) {
            activity('Companionunit')
                ->performedOn($Comunit)
                ->withProperties($request->all())
                ->log('User: :causer.email - Add Companionunit - name: :properties.name, id: ' . $Comunit->id);

            return redirect()->route('vne.companionunit.manage')->with('success', trans('vne-companionunit::language.messages.success.create'));
        } else {
            return redirect()->route('vne.companionunit.manage')->with('error', trans('vne-companionunit::language.messages.error.create'));
        }
    }

    public function create()
    {
        $comtype = Comgroup::all();
        return view('VNE-COMPANIONUNIT::modules.companionunit.create', compact('comtype', $comtype));
    }

    public function delete(Request $request)
    {
        $id = $request->input('id');
        $comunit = $this->Comunit->findOrFail($id);

        if (null != $comunit) {
            $this->Comunit->delete($id);

            activity('comunit')
                ->performedOn($comunit)
                ->withProperties($request->all())
                ->log('User: :causer.email - Delete Companionunit - id: :properties.id, name: ' . $comunit->comname);

            return redirect()->route('vne.companionunit.manage')->with('success', trans('vne-companionunit::language.messages.success.delete'));
        } else {
            return redirect()->route('vne.companionunit.manage')->with('error', trans('vne-companionunit::language.messages.error.delete'));
        }
    }

    public function manage()
    {
        return view('VNE-COMPANIONUNIT::modules.companionunit.manage');
    }

    public function show(Request $request)
    {
        $id = $request->input('id');
        $Comunit = $this->Comunit->findOrFail($id);
        $x = $Comunit->comtype;
        $comtype = Comgroup::findOrFail($x);
//        dd($comtype);
        $comgroup = Comgroup::all();
        $data = [
            'Comunit' => $Comunit,
            'comtype' => $comtype,
            'comgroup' => $comgroup
        ];

        return view('VNE-COMPANIONUNIT::modules.companionunit.edit', $data);
    }

    public function update(CompanionunitRequest $request)
    {
        $id = $request->input('id');
        $comunit = $this->Comunit->findOrFail($id);
        try {
            $comunit->comname = $request->input('comname');
            $comunit->comlink = $request->input('comlink');
            $comunit->comnote = $request->input('comnote');
            $comunit->comtype = $request->input('comtype');
            $comunit->img = $request->input('img');
            $comunit->save();
        } catch (\Exception $e) {
            return redirect()->route('vne.companionunit.create')->with('error', $e->getMessage());
        }
        if ($comunit->id) {
            activity('Comunit')
                ->performedOn($comunit)
                ->withProperties($request->all())
                ->log('User: :causer.email - Update Companionunit - name: :properties.name, id: ' . $comunit->id);
            return redirect()->route('vne.companionunit.manage')->with('success', trans('vne-companionunit::language.messages.success.update'));
        } else {
            return redirect()->route('vne.companionunit.show', ['id' => $request->input('id')])->with('error', trans('vne-companionunit::language.messages.error.update'));
        }
    }

    public function getModalDelete(Request $request)
    {
        $model = 'Companionunit';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $confirm_route = route('vne.companionunit.delete', ['id' => $request->input('id')]);
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
        $model = 'Companionunit';
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
        return Datatables::of($this->Comunit->findAll())
            ->addColumn('actions', function ($Comunit) {
                $actions = '<a href=' . route('vne.companionunit.log', ['type' => 'Comunit', 'id' => $Comunit->id]) . ' data-toggle="modal" data-target="#log"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="log Comunit"></i></a>
                        <a href=' . route('vne.companionunit.show', ['id' => $Comunit->id]) . '><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="update Comunit"></i></a>
                        <a href=' . route('vne.companionunit.confirm-delete', ['id' => $Comunit->id]) . ' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete Comunit"></i></a>';
                return $actions;
            })
            ->editColumn('img', function ($Comunit) {
                $img = $Comunit->img;
                return '<img src=' . $img . ' height="auto" width="100%">';
            })
            ->addIndexColumn()
            ->rawColumns(['actions', 'img'])
            ->make();
    }
    //api
    public function getcomunit(Request $request)
    {
        $comunit = Companionunit::select('id','comname','comlink','img','comnote')->where('comtype',$request->type)->get();
        if ($comunit == null) {
            return response()->json(['data' => null], 500);
        }
        return response()->json(['data' => $comunit], 200);
    }
}
