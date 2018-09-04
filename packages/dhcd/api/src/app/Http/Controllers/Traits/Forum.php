<?php

namespace Dhcd\Api\App\Http\Controllers\Traits;

use Dhcd\Topic\App\Models\Topic as TopicModel;
use Illuminate\Support\Facades\DB;
use Validator;
use Cache;

trait Forum
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );

    public function getForum($request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric'
//            'token' => 'required',
        ], $this->messages);
        if (!$validator->fails()) {
            Cache::forget('api_forum');
            if (Cache::has('api_forum')) {
                $forums = Cache::get('api_forum');
            } else {
                $member_id = $request->input('id');
                $forumHas = TopicModel::select(DB::raw('1 as joined, dhcd_topic.*'))->with('getMember')
                    ->whereHas('getMember', function ($query) use ($member_id) {
                        $query->where('dhcd_topic_has_member.member_id', $member_id);
                        $query->where('dhcd_topic_has_member.deleted_at', null);
                    })
                    ->where('status', 1)
                    ->get();

                $forumNotHas = TopicModel::select(DB::raw('0 as joined, dhcd_topic.*'))->with('getMember')
                    ->whereDoesntHave('getMember', function ($query) use ($member_id) {
                        $query->where('dhcd_topic_has_member.member_id', $member_id);
                    })
                    ->where('status', 1)
                    ->get();

                $forums = $forumHas->merge($forumNotHas);

                $expiresAt = now()->addMinutes(3600);
                Cache::put('api_forum', $forums, $expiresAt);
            }

            $list_forums = [];
            if (count($forums) > 0) {
                foreach ($forums as $forum) {
                    $item = new \stdClass();
                    $item->id = $forum->topic_id;
                    $item->title = $forum->name;
                    $item->photo = $forum->image;
                    $item->date_created = date_format($forum->created_at, 'Y-m-d');
                    $item->date_modified = date_format($forum->updated_at, 'Y-m-d');
                    $item->isEnable = ($forum->joined == 1) ? true : false;

                    $list_forums[] = $item;
                }
            }

            $data = '{
                    "data": {
                        "list_forums": '. json_encode($list_forums) .'
                    },
                    "success" : true,
                    "message" : "ok!"
                }';
            $data = str_replace('null', '""', $data);
            return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
        } else {
            return $validator->messages();
        }

    }
}