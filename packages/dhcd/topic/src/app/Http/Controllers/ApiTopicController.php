<?php

namespace Dhcd\Topic\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

use Dhcd\Topic\App\Http\Requests\ApiTopicRequest;

use Dhcd\Topic\App\Models\Topic;
use Dhcd\Topic\App\Models\TopicHasMember;

use Dhcd\Topic\App\Repositories\TopicRepository;


use Validator,Auth,DB,Hash;

class ApiTopicController extends BaseController
{	
	private $messages = array(
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );
    public function __construct(TopicRepository $topicRepository)
    {
        $this->topic = $topicRepository;
    }

	public function getTopic(ApiTopicRequest $request){
		$data = [
			"success" => false,
			"message" => "Lấy danh sách thất bại",	
		];
		$validator = Validator::make($request->all(), [
            'id' => 'required|min:1|numeric',
            'token' => 'required'
        ], $this->messages);
        if (!$validator->fails()) {
        	$member_id = $request->input('id');
        	//list topic thuoc member
        	$list_topic_id_tmp = $list_topic_id = array();
			$list_topic_id_tmp = TopicHasMember::where('member_id', $member_id)->select('topic_id')->get();
			if(count($list_topic_id_tmp) > 0){
				foreach ($list_topic_id_tmp as $key1 => $value1) {
					$list_topic_id[] = $value1->topic_id;
				}
			}
			$topics = Topic::where('status',1)->get();
			if( count($topics) > 0){
				$data_topic = array();
				foreach ($topics as $key => $topic) {
					$data_topic[] = [
                        "id"   => $topic->topic_id,
                        "title" => $topic->name,
                        "photo" => $topic->image != '' ? $topic->image : '',
                        "isEnable" => in_array($topic->topic_id, $list_topic_id) ? true : false,
                        "date_created" => date_format($topic->created_at, 'd-m-Y'),
                        "date_modified" => date_format($topic->updated_at, 'd-m-Y'),
					];	
				}
				$data = [
					"success" => true,
					"message" => "",
					"data" => [
						"list_forums" => $data_topic
					]	
				];
				return response(json_encode($data))->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
			}
        }
        return response(json_encode($data))->setStatusCode(404)->header('Content-Type', 'application/json; charset=utf-8');
	}
}