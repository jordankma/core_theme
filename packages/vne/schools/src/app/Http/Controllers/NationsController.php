<?php
/**
 * Created by PhpStorm.
 * User: CuongPT
 * Date: 11/14/2018
 * Time: 11:13 AM
 */

namespace Vne\Schools\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Vne\Schools\App\Repositories\NationsRepository;
use Vne\Schools\App\Http\Requests\NationsRequest;
use Vne\Schools\App\Models\Nations;
use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator;

class NationsController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric' => "Phải là số"
    );

    public function __construct(NationsRepository $nationsRepository)
    {
        parent::__construct();
        $this->nations = $nationsRepository;
    }

    public function add(NationsRequest $request)
    {
        try {
            $nations = new Nations($request->all());
            $nations->nation = $request->input('nation');
            $nations->alias = str_slug($request->input('nation'));
            $nations->save();
        } catch (\Exception $e) {
            return redirect()->route('vne.nations.create')->with('error', $e->getMessage());
        }
        if ($nations->id) {
            activity('nations')
                ->performedOn($nations)
                ->withProperties($request->all())
                ->log('User: :causer.email - Add Nations - nation: :properties.nations, id' . $nations->id);
            return redirect()->route('vne.nations.manage')->with('success', trans('vne-schools::language.messages.success.addsuccess'));
        } else {
            return redirect()->route('vne.nations.create')->with('error', trans('vne-schools::language.messages'));
        }
    }

    public function create()
    {
        return view('VNE-SCHOOLS::modules.nations.create');
    }

    public function delete(Request $request)
    {
        $id = (int)$request->input('id');
        $nations = $this->nations->find($id);
        if (null != $nations) {
            $this->nations->delete($id);
            activity('nations')
                ->performedOn($nations)
                ->withProperties($request->all())
                ->log('User: :causer.email - Delete Nations - id: :properties.id, catunit: ' . $nations->nations);

            return redirect()->route('vne.nations.manage')->with('success', trans('vne-schools::language.messages.success.delete'));
        } else {
            return redirect()->route('vne.nations.manage')->with('error', trans('vne-schools::language.messages.error.delete'));
        }
    }

    public function manage()
    {
        return view('VNE-SCHOOLS::modules.nations.manage');
    }

    public function show(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            $id = (int)$request->input('id');
            $nation = Nations::findOrFail($id);
            $data = [
                'nation' => $nation,
            ];
            return view('VNE-SCHOOLS::modules.nations.edit', $data);
        } else {
            return $validator->messages();
        }
    }

    public function update(NationsRequest $request)
    {
        $id = $request->input('id');
        $nations = Nations::findOrFail((int)$id);
        $nations->nation = $request->input('nation');
        $nations->alias = str_slug($request->input('nation'));
        if ($nations->update()) {

            activity('nations')
                ->performedOn($nations)
                ->withProperties($request->all())
                ->log('User: :causer.email - Update Nations - id: :properties.id, name: :properties.nations');

            return redirect()->route('vne.nations.manage')->with('success', trans('vne-schools::language.messages.success.update'));
        } else {
            return redirect()->route('vne.nations.show', ['id' => $request->input('id')])->with('error', trans('vne-schools::language.messages.error.update'));
        }
    }

    public function getModalDelete(Request $request)
    {
        $model = 'nations';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $confirm_route = route('vne.nations.delete', ['id' => (int)$request->input('id')]);
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
        $model = 'nations';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $logs = Activity::where([
                    ['log_name', $model],
                    ['subject_id', (int)$request->input('id')]
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
        return Datatables::of($this->nations->findAll())
            ->addColumn('actions', function ($nations) {
                $actions = '<a href=' . route('vne.nations.log', ['type' => 'nations', 'id' => $nations->id]) . ' data-toggle="modal" data-target="#log"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="log nations"></i></a>
                        <a href=' . route('vne.nations.show', ['id' => $nations->id]) . '><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="update nations"></i></a>
                        <a href=' . route('vne.nations.confirm-delete', ['id' => $nations->id]) . ' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete nations"></i></a>';
                return $actions;
            })
            ->addIndexColumn()
            ->rawColumns(['actions'])
            ->make(true);
    }
    //api trả về các quốc gia
    public function getnations()
    {
        $nations = Nations::select('id','nation','alias')->get();
        if ($nations == null) {
            return response()->json(['data' => null], 500);
        }
        return response()->json(['data' => $nations], 200);
    }
}