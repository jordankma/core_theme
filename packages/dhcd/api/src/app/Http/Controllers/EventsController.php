<?php

namespace Dhcd\Api\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
//use Dhcd\Api\App\Http\Resources\EventsResource;
use Dhcd\Events\App\Models\Events;
use Cache;
use Crypt;

class EventsController extends BaseController
{
    public function getEvents()
    {
        Cache::forget('api_events');
        if (Cache::has('api_events')) {
            $events = Cache::get('api_events');
        } else {
            $events = Events::all();
            $expiresAt = now()->addMinutes(3600);
            Cache::put('api_events', $events, $expiresAt);
        }

        $list_events = [];
        if (count($events) > 0) {
            foreach ($events as $event) {
                $item = new \stdClass();
                $item->id = $event->event_id;
                $item->title_day = $event->name;
                $item->date = $event->date;
                $item->content = $event->content;
                $item->events = json_decode($event->event_detail);

                $list_events[] = $item;
            }
        }

        $data = '{
                    "data": {
                        "list_day_event": '. json_encode($list_events) .'
                    },
                    "success" : true,
                    "message" : "ok!"
                }';
        return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
//        return (EventsResource::collection($events))->additional(['success' => true, 'message' => 'ok!', 'current_day' => $current_day])->response()->setStatusCode(200)->setCharset('utf-8');
    }
}