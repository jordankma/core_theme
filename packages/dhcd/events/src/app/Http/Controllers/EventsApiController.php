<?php

namespace Dhcd\Events\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Dhcd\Events\App\Repositories\EventsRepository;
use Dhcd\Events\App\Models\Events;
use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Dhcd\Events\App\Http\Resources\Eventapi;

use Response;
use Validator;
use Auth;

class EventsApiController extends BaseController
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
     public function events()
    {
        //for api
        try{
        $current_day = date("Y-m-d");
        $events = Events::select('event_id','name','date','content','event_detail')->where('deleted_at',null)->orderBy('date', 'asc')->get();
        return Response::json([
            'success'=>'true',
            'massage'=>'success',
            'current_day'=>$current_day,
            'data' =>['list_event_day'=>$events]],
            200,
            ['Content-type'=> 'application/json; charset=utf-8'],
            JSON_UNESCAPED_UNICODE);
        }catch(Exception $e){
            return Response::json(['errors' => 'Bad Request'], 400);
        }
    }
}