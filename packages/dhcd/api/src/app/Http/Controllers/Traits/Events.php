<?php

namespace Dhcd\Api\App\Http\Controllers\Traits;

use Dhcd\Events\App\Models\Events as EventsModel;
use Validator;
use Cache;

trait Events
{
    public function getEvents()
    {
        $cache_name = 'api_events';
        Cache::forget($cache_name);
        if (Cache::has($cache_name)) {
            $events = Cache::get($cache_name);
        } else {
            $events = EventsModel::where('date', '>=', date('Y-m-d'))->orderBy('date')->get();
            $expiresAt = now()->addMinutes(3600);
            Cache::put($cache_name, $events, $expiresAt);
        }

        $list_events = [];
        if (count($events) > 0) {
            foreach ($events as $event) {

                $arrDetail = json_decode($event->event_detail, true);
                if (count($arrDetail) > 0) {
                    foreach ($arrDetail as $k => $detail) {

                        $item = new \stdClass();
                        $item->start_time = base64_encode($detail['start_time']);
                        $item->end_time = base64_encode($detail['end_time']);
                        $item->content = base64_encode($detail['content']);

                        $arrDetail[$k] = $item;
                    }
                }

                $item = new \stdClass();
                $item->id = $event->event_id;
                $item->title_day = base64_encode($event->name);
                $item->date = base64_encode(date("d-m-Y", strtotime($event->date)));
                $item->content = base64_encode($event->content);
                $item->events = $arrDetail;

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
        $data = str_replace('null', '""', $data);
        return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
    }
}