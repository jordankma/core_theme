<?php

namespace Contest\Contest\App\Http\Controllers;

use Contest\Contest\App\Models\Contest;
use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;

use Validator, Cache;

class ApiController extends Controller
{
   public function testQuestionPack(Request $request){
       if(!empty($request->question_pack_id)){
           $path = file_get_contents('http://quiz2.vnedutech.vn/admin/toolquiz/contest/get-json/'.$request->question_pack_id);
           $data = file_get_contents($path);
           $data = json_decode($data, true);
           foreach ($data['dethi']['list_round'] as $key => $item) {
               foreach ($data['dethi']['list_round'][$key]['listQuestRound'] as $key1 => $item1){
                   $data['dethi']['list_round'][$key]['listQuestRound'][$key1]['q'] = base64_decode($item['listQuestRound'][$key1]['q']);
                   foreach ($item1['ans'] as $key2 => $item2) {
                       $data['dethi']['list_round'][$key]['listQuestRound'][$key1]['ans'][$key2]['text'] = base64_decode( $item['listQuestRound'][$key1]['ans'][$key2]['text']);
                   }
               }
           }
           echo "<pre>";print_r($data);echo "</pre>";die;
       }
   }
   public function getContestConfig(Request $request){
       $res = [
           'status' => false,
           'data' => null,
           'messages' => ''
       ];
       if(isset($request->reload_cache) || !Cache::has('contest_config')){
           if(!empty($request->contest_id)){
               $contest = Contest::where('contest_id', (int)$request->contest_id)->first();
               if(!empty($contest)){
                   $test_api = 'admin/api/contest/exam_info?type=test';
                   $real_api = 'admin/api/contest/exam_info?type=real';
                   $arr = [
                       'id' => $contest->contest_id,
                       'name' => $contest->name,
                       'db_mysql' => $contest->db_mysql,
                       'db_mongo' => $contest->db_mongo,
                       'domain' => $contest->domain_name,
                       'config' => [
                           'test' => null,
                           'real' => null
                       ]

                   ];
                   try{
                       $arr['config']['test'] = json_decode(file_get_contents('http://'.$contest->domain_name.'/'.$test_api),true);
                       $arr['config']['real'] = json_decode(file_get_contents('http://'.$contest->domain_name.'/'.$real_api),true);




                       if($arr['config']['test']['success']){
                           if($arr['config']['test']['success'] == false){
                               $arr['config']['test'] = null;
                           }
                       }
                       if($arr['config']['real']['success']){
                           if($arr['config']['real']['success'] == false){
                               $arr['config']['real'] = null;
                           }
                       }


                       $res = [
                           'status' => true,
                           'data' => $arr,
                           'messages' => ''
                       ];
                   }
                   catch (\Exception $e){

                   }
               }
               else{
                   $res = [
                       'status' => false,
                       'data' => [],
                       'messages' => 'Cuộc thi không tồn tại'
                   ];
               }
           }
           else{
               $contests = Contest::all();
               $arr = [];
               if(!empty($contests)){
                   $test_api = 'admin/api/contest/exam_info?type=test';
                   $real_api = 'admin/api/contest/exam_info?type=real';
                   foreach ($contests as $key => $contest) {
                       $arr[$key] = [
                           'id' => $contest->contest_id,
                           'name' => $contest->name,
                           'db_mysql' => $contest->db_mysql,
                           'db_mongo' => $contest->db_mongo,
                           'domain' => $contest->domain_name,
                           'config' => [
                               'test' => null,
                               'real' => null
                           ]

                       ];
                       try{
                           $test = json_decode(file_get_contents('http://'.$contest->domain_name.'/'.$test_api),true);
                           $real = json_decode(file_get_contents('http://'.$contest->domain_name.'/'.$real_api),true);

                           if(!empty($test['success']) && $test['success'] == true){
                               $arr[$key]['config']['test'] = $test;
                           }

                           if(!empty($real['success']) && $real['success'] == true){
                               $arr[$key]['config']['real'] = $real;
                           }
                       }
                       catch (\Exception $e){

                       }
                   }
                   $res = [
                       'status' => true,
                       'data' => $arr,
                       'messages' => ''
                   ];
               }
               else{
                   $res = [
                       'status' => false,
                       'data' => [],
                       'messages' => 'Không có cuộc thi nào'
                   ];
               }
           }

           Cache::forever('contest_config', $res);
       }
       else{
            $res = Cache::get('contest_config');
       }

       return response()->json($res);
   }
   public function getContestConfigAll(Request $request){
       $res = [
           'status' => false,
           'data' => null,
           'messages' => ''
       ];
        if(!empty($request->contest_id)){
            $contest = Contest::where('contest_id', (int)$request->contest_id)->first();
            if(!empty($contest)){
                $test_api = 'admin/api/contest/exam_info?type=test';
                $real_api = 'admin/api/contest/exam_info?type=real';
                $arr = [
                    'id' => $contest->contest_id,
                    'name' => $contest->name,
                    'db_mysql' => $contest->db_mysql,
                    'db_mongo' => $contest->db_mongo,
                    'domain' => $contest->domain_name,
                    'config' => [
                        'test' => null,
                        'real' => null
                    ]
                ];
                try{
                    $arr['config']['test'] = json_decode(file_get_contents('http://'.$contest->domain_name.'/'.$test_api),true);
                    $arr['config']['real'] = json_decode(file_get_contents('http://'.$contest->domain_name.'/'.$real_api),true);

                    $res = [
                        'status' => true,
                        'data' => $arr,
                        'messages' => ''
                    ];
                }
                catch (\Exception $e){

                }
            }
            else{
                $res = [
                    'status' => false,
                    'data' => [],
                    'messages' => 'Cuộc thi không tồn tại'
                ];
            }
        }
        else{
            $contests = Contest::all();
            $arr = [];
          if(!empty($contests)){
              $test_api = 'admin/api/contest/exam_info?type=test';
              $real_api = 'admin/api/contest/exam_info?type=real';
              foreach ($contests as $key => $contest) {
                  $arr[$key] = [
                      'id' => $contest->contest_id,
                      'name' => $contest->name,
                      'db_mysql' => $contest->db_mysql,
                      'db_mongo' => $contest->db_mongo,
                      'domain' => $contest->domain_name,
                      'config' => [
                          'test' => null,
                          'real' => null
                      ]

                  ];
                  try{
                      $arr[$key]['config']['test'] = json_decode(file_get_contents('http://'.$contest->domain_name.'/'.$test_api),true);
                      $arr[$key]['config']['real'] = json_decode(file_get_contents('http://'.$contest->domain_name.'/'.$real_api),true);
                  }
                  catch (\Exception $e){

                  }
              }
              $res = [
                  'status' => true,
                  'data' => $arr,
                  'messages' => ''
              ];
          }
          else{
              $res = [
                  'status' => false,
                  'data' => [],
                  'messages' => 'Không có cuộc thi nào'
              ];
          }
        }
       return response()->json($res);
   }
}
