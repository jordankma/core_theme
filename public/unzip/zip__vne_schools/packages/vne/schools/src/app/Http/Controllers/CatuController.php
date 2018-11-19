<?php

namespace Vne\Schools\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Vne\Schools\App\Http\Requests\CatuRequest;
use Vne\Schools\App\Repositories\CatuRepository;
use Vne\Schools\App\Models\CatUnit;
use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator;

class CatuController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric' => "Phải là số"
    );

    public function __construct(CatuRepository $catunitRepository)
    {
        parent::__construct();
        $this->catunit = $catunitRepository;
    }

    public function add(CatuRequest $request)
    {
        try {
            $catunit = new CatUnit($request->all());
            $catunit->nextid();
            $catunit->catunit = $request->input('catunit');
            $catunit->save();
        } catch (\Exception $e) {
            return redirect()->route('vne.catunit.create')->with('error', $e->getMessage());
        }
        if ($catunit->_id) {
            activity('catunit')
                ->performedOn($catunit)
                ->withProperties($request->all())
                ->log('User: :causer.email - Add CatUnit - catunit: :properties.catunit, _id' . $catunit->_id);
            return redirect()->route('vne.catunit.manage')->with('success', trans('vne-schools::language.messages.success.addsuccess'));
        } else {
            return redirect()->route('vne.catunit.create')->with('error', trans('vne-schools::language.messages'));
        }
    }

    public function create()
    {
        return view('VNE-SCHOOLS::modules.catunit.create');
    }

    public function delete(Request $request)
    {
        $_id = (int)$request->input('_id');
        $catunit = $this->catunit->find($_id);
        if (null != $catunit) {
            $this->catunit->delete($_id);
            activity('catunit')
                ->performedOn($catunit)
                ->withProperties($request->all())
                ->log('User: :causer.email - Delete CatUnit - _id: :properties._id, catunit: ' . $catunit->catunit);

            return redirect()->route('vne.catunit.manage')->with('success', trans('vne-schools::language.messages.success.delete'));
        } else {
            return redirect()->route('vne.catunit.manage')->with('error', trans('vne-schools::language.messages.error.delete'));
        }
    }

    public function manage()
    {
        return view('VNE-SCHOOLS::modules.catunit.manage');
    }

    public function show(Request $request)
    {
        $validator = Validator::make($request->all(), [
            '_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            $_id = (int)$request->input('_id');
            $catunit = CatUnit::findOrFail($_id);
            $data = [
                'catunit' => $catunit,
            ];
            return view('VNE-SCHOOLS::modules.catunit.edit', $data);
        } else {
            return $validator->messages();
        }
    }

    public function update(CatuRequest $request)
    {
        $_id = $request->input('_id');
        $catunit = CatUnit::findOrFail((int)$_id);
        $catunit->catunit = $request->input('catunit');
        if ($catunit->update()) {

            activity('catunit')
                ->performedOn($catunit)
                ->withProperties($request->all())
                ->log('User: :causer.email - Update CatUnit - _id: :properties._id, name: :properties.catunit');

            return redirect()->route('vne.catunit.manage')->with('success', trans('vne-schools::language.messages.success.update'));
        } else {
            return redirect()->route('vne.catunit.show', ['_id' => $request->input('_id')])->with('error', trans('vne-schools::language.messages.error.update'));
        }
    }

    public function getModalDelete(Request $request)
    {
        $model = 'catunit';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            '_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $confirm_route = route('vne.catunit.delete', ['_id' => (int)$request->input('_id')]);
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
        $model = 'catunit';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            '_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $logs = Activity::where([
                    ['log_name', $model],
                    ['subject_id', (int)$request->input('_id')]
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
        return Datatables::of($this->catunit->findAll())
            ->addColumn('actions', function ($catunit) {
                $actions = '<a href=' . route('vne.catunit.log', ['type' => 'catunit', '_id' => $catunit->_id]) . ' data-toggle="modal" data-target="#log"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="log catunit"></i></a>
                        <a href=' . route('vne.catunit.show', ['_id' => $catunit->_id]) . '><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="update catunit"></i></a>
                        <a href=' . route('vne.catunit.confirm-delete', ['_id' => $catunit->_id]) . ' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete catunit"></i></a>';
                return $actions;
            })
            ->addIndexColumn()
            ->rawColumns(['actions'])
            ->make(true);
    }

}
