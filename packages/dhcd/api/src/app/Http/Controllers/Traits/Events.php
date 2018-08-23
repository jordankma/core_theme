<?php

namespace Dhcd\Api\App\Http\Controllers\Traits;

use Dhcd\Events\App\Models\Events as EventsModel;
use Validator;
use Cache;

trait Events
{
    public function getEvents()
    {
        Cache::forget('api_events');
        if (Cache::has('api_events')) {
            $events = Cache::get('api_events');
        } else {
            $events = EventsModel::all();
            $expiresAt = now()->addMinutes(3600);
            Cache::put('api_events', $events, $expiresAt);
        }

        $list_events = [];
        if (count($events) > 0) {
            foreach ($events as $event) {
                $item = new \stdClass();
                $item->id = $event->event_id;
                $item->title_day = $event->name;
                $item->date = date("d-m-Y", strtotime($event->date));
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
    }
}