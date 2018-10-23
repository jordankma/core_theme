<?php

namespace Contest\Contestmanage\App\Http\Controllers;

use Contest\Contestmanage\App\Repositories\ContestTagRepository;
use Dhcd\Contest\App\Repositories\ContestRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Illuminate\Support\Facades\Schema;
use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator;

class ContestTagController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );

    public function __construct(ContestTagRepository $tagRepository)
    {
        parent::__construct();
        $this->tag = $tagRepository;
    }

    public function add(Request $request)
    {

            if ($tag->product_id) {


//                dd(shell_exec('cd ../ && /egserver/php/bin/php /egserver/php/bin/composer dump-autoload'));
                activity('cardProduct')
                    ->performedOn($tag)
                    ->withProperties($request->all())
                    ->log('User: :causer.email - Add cardProduct - name: :properties.name, product_id: ' . $tag->product_id);

                return redirect()->route('contest.contestmanage.contest_tag.manage')->with('success', trans('card-contestmanage::language.messages.success.create'));
            } else {
                return redirect()->route('contest.contestmanage.contest_tag.manage')->with('error', trans('card-contestmanage::language.messages.error.create'));
            }

    }

    public function create()
    {
        return view('CONTEST-CONTESTMANAGE::modules.contestmanage.contest_tag.create');
    }

    public function delete(Request $request)
    {
        $product_id = $request->input('product_id');
        $tag = $this->cardProduct->find($product_id);

        if (null != $tag) {
            $this->cardProduct->delete($product_id);

            activity('cardProduct')
                ->performedOn($tag)
                ->withProperties($request->all())
                ->log('User: :causer.email - Delete cardProduct - product_id: :properties.product_id, name: ' . $tag->product_name);

            return redirect()->route('contest.contestmanage.contest_tag.manage')->with('success', trans('card-contestmanage::language.messages.success.delete'));
        } else {
            return redirect()->route('contest.contestmanage.contest_tag.manage')->with('error', trans('card-contestmanage::language.messages.error.delete'));
        }
    }

    public function manage()
    {
        return view('CONTEST-CONTESTMANAGE::modules.contestmanage.contest_tag.manage');
    }

    public function show(Request $request)
    {
        $product_id = $request->input('product_id');
        $tag = $this->cardProduct->find($product_id);
        $data = [
            'tag' => $tag,
        ];

        return view('CONTEST-CONTESTMANAGE::modules.contestmanage.contest_tag.edit', $data);
    }

    public function update(CardProductRequest $request)
    {
        $product_id = $request->input('product_id');
        $tag = $this->cardProduct->find($product_id);
        $tag->product_name=$request->input('name');
        $tag->product_code=strtoupper($request->input('code'));
        $tag->description=$request->input('description');
        if ($tag->save()) {

            activity('cardProduct')
                ->performedOn($tag)
                ->withProperties($request->all())
                ->log('User: :causer.email - Update cardProduct - product_id: :properties.product_id, name: :properties.product_name');

            return redirect()->route('contest.contestmanage.contest_tag.manage')->with('success', trans('card-contestmanage::language.messages.success.update'));
        } else {
            return redirect()->route('contest.contestmanage.contest_tag.show', ['product_id' => $request->input('product_id')])->with('error', trans('card-contestmanage::language.messages.error.update'));
        }
    }

    public function getModalDelete(Request $request)
    {
        $model = 'cardProduct';
        $tittle='Xác nhận xóa';
        $type=$this->cardProduct->find($request->input('product_id'));
        $content='Bạn có chắc chắn muốn xóa loại: '.$type->product_name.'?';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $confirm_route = route('contest.contestmanage.contest_tag.delete', ['product_id' => $request->input('product_id')]);
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
        $model = 'cardProduct';
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
        }
        else {
            return $validator->messages();
        }
    }

    //Table Data to index page
    public function data()
    {
        return Datatables::of($this->cardProduct->findAll())
            ->addColumn('actions', function ($tag) {
                $actions = '<a href=' . route('contest.contestmanage.contest_tag.log', ['type' => 'cardProduct', 'id' => $tag->product_id]) . ' data-toggle="modal" data-target="#log"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="log cardProduct"></i></a>';
//                        <a href=' . route('contest.contestmanage.contest_tag.confirm-delete', ['product_id' => $tag->product_id]) . ' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete cardProduct"></i></a>';

                return $actions;
            })
            ->rawColumns(['actions'])
            ->make();
    }


}