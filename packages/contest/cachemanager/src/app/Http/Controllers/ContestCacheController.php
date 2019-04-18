<?php

namespace Contest\Cachemanager\App\Http\Controllers;

use Contest\Cachemanager\App\Models\ContestCache;
use Contest\Cachemanager\App\Repositories\ContestCacheRepository;
use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Contest\Cachemanager\App\Repositories\contest_cacheRepository;
use Contest\Cachemanager\App\Models\contest_cache;
use Illuminate\Support\Facades\Cache;
use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator;

class ContestCacheController extends Controller
{

    public function __construct(ContestCacheRepository $cacheRepository)
    {
        parent::__construct();
        $this->cache = $cacheRepository;
    }

    public function add(Request $request)
    {
        $contest_cache = new ContestCache($request->all());
        $contest_cache->save();

        if ($contest_cache->cache_id) {

            activity('contest_cache')
                ->performedOn($contest_cache)
                ->withProperties($request->all())
                ->log('User: :causer.email - Add contest_cache - name: :properties.name, cache_id: ' . $contest_cache->cache_id);

            return redirect()->route('contest.cachemanager.contest_cache.manage')->with('success', trans('contest-cachemanager::language.messages.success.create'));
        } else {
            return redirect()->route('contest.cachemanager.contest_cache.manage')->with('error', trans('contest-cachemanager::language.messages.error.create'));
        }
    }

    public function create()
    {
        return view('CONTEST-CACHEMANAGER::modules.cachemanager.contest_cache.create');
    }

    public function delete(Request $request)
    {
        $cache_id = $request->input('cache_id');
        $contest_cache = $this->cache->find($cache_id);

        if (null != $contest_cache) {
            $this->cache->delete($cache_id);

            activity('contest_cache')
                ->performedOn($contest_cache)
                ->withProperties($request->all())
                ->log('User: :causer.email - Delete contest_cache - cache_id: :properties.cache_id, name: ' . $contest_cache->name);

            return redirect()->route('contest.cachemanager.contest_cache.manage')->with('success', trans('contest-cachemanager::language.messages.success.delete'));
        } else {
            return redirect()->route('contest.cachemanager.contest_cache.manage')->with('error', trans('contest-cachemanager::language.messages.error.delete'));
        }
    }

    public function manage()
    {
        return view('CONTEST-CACHEMANAGER::modules.cachemanager.contest_cache.manage');
    }

    public function show(Request $request)
    {
        $cache_id = $request->input('cache_id');
        $contest_cache = $this->cache->find($cache_id);
        $data = [
            'contest_cache' => $contest_cache
        ];

        return view('CONTEST-CACHEMANAGER::modules.cachemanager.contest_cache.edit', $data);
    }

    public function update(Request $request)
    {
        $cache_id = $request->input('cache_id');

        $contest_cache = $this->cache->find($cache_id);
        $contest_cache->name = $request->input('name');

        if ($contest_cache->save()) {

            activity('contest_cache')
                ->performedOn($contest_cache)
                ->withProperties($request->all())
                ->log('User: :causer.email - Update contest_cache - cache_id: :properties.cache_id, name: :properties.name');

            return redirect()->route('contest.cachemanager.contest_cache.manage')->with('success', trans('contest-cachemanager::language.messages.success.update'));
        } else {
            return redirect()->route('contest.cachemanager.contest_cache.show', ['cache_id' => $request->input('cache_id')])->with('error', trans('contest-cachemanager::language.messages.error.update'));
        }
    }

    public function getModalDelete(Request $request)
    {
        $model = 'contest_cache';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'cache_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $confirm_route = route('contest.cachemanager.contest_cache.delete', ['cache_id' => $request->input('cache_id')]);
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
        $model = 'contest_cache';
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

    public function reload(Request $request){

        if(!empty($request->cache_id)){
            $cache = $this->cache->find($request->cache_id);
            if(!empty($cache->cache_tags)){
                Cache::tag([$cache->cache_tags])->forget($cache->cache_key);
            }
            else{
                Cache::forget($cache->cache_key);
            }
            return redirect()->route('contest.cachemanager.contest_cache.manage')->with('success', trans('contest-cachemanager::language.messages.success.reload'));

        }
        else{
            return redirect()->route('contest.cachemanager.contest_cache.manage')->with('error', trans('contest-cachemanager::language.messages.error.reload'));
        }
    }
    //Table Data to index page
    public function data()
    {
        return Datatables::of($this->cache->findAll())
            ->addColumn('actions', function ($contest_cache) {
                $actions = '<a href=' . route('contest.cachemanager.contest_cache.log', ['type' => 'contest_cache', 'id' => $contest_cache->cache_id]) . ' data-toggle="modal" data-target="#log"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="log contest_cache"></i></a>
                        <a href=' . route('contest.cachemanager.contest_cache.reload', ['cache_id' => $contest_cache->cache_id]) . '><i class="livicon" data-name="refresh" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="reload cache"></i></a>
                        <a href=' . route('contest.cachemanager.contest_cache.confirm-delete', ['cache_id' => $contest_cache->cache_id]) . ' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete contest_cache"></i></a>';

                return $actions;
            })
            ->addColumn('status', function ($contest_cache) {
                if($this->checkCacheStatus($contest_cache->cache_tags,$contest_cache->cache_key)){
                    return '<span><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#01BC8C" data-hc="#01BC8C"></i> Đã lưu</span>';
                }
                else{
                    return '<span><i class="livicon" data-name="remove" data-size="18" data-loop="true" data-c="#A9B6BC" data-hc="#A9B6BC"></i> Chưa lưu</span>';
                }
            })
            ->addIndexColumn()
            ->rawColumns(['actions','status'])
            ->make();
    }

    function checkCacheStatus($tags,$key){
        $res = false;
        if(!empty($tags)){
            $res = Cache::tag([$tags])->has($key);
        }
        else{
            $res = Cache::has($key);
        }
        return $res;
    }
}
