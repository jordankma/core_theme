<?php

namespace Dhcd\Api\App\Http\Controllers\Traits;

use Dhcd\Notification\App\Models\LogSent as LogSentModel;
use Validator;
use Cache;

trait Logsent
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );

    public function getLogSent($request){
        $page = $request->input('page', 1);

        $log_sents = LogSentModel::orderBy('log_sent_id', 'desc')->with('notification')->paginate(20);
        $list_log_sent = array();
        if (count($log_sents) > 0) {
            foreach ($log_sents as $key => $value) {
                $list_log_sent[] = [
                    'id' => $value->log_sent_id,
                    'name' => base64_encode($value->notification->name),
                    'content' => base64_encode($value->notification->content),
                    'created_at' => strtotime($value->created_at) * 1000
                ];
            }
        }
        $total_page = $log_sents->lastPage();
        $data = '{
                    "data": {
                        "list_log_sent": '. json_encode($list_log_sent) .',
                        "total_page": ' . $total_page . ',
                        "current_page": '. $page .'
                    },
                    "success" : true,
                    "message" : "ok!"
                }';
        $data = str_replace('null', '""', $data);
        return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
    }

    public function getLogSentDetail($request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            $id = $request->input('id');
            $log_sent = LogSentModel::where('log_sent_id', $id)->with('notification')->first();
            $log_sent_data = [
                'id' => $log_sent->log_sent_id,
                'name' => base64_encode($log_sent->notification->name),
                'content' => base64_encode($log_sent->notification->content),
                'created_at' => strtotime($log_sent->created_at) * 1000
            ];
            $data = '{
                    "data": '. json_encode($log_sent_data) .',
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