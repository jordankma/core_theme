<?php

namespace Vne\Hocvalamtheobac\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\MController as Controller;


use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator,Datetime,Session,URL,Schema;

class ContestController extends Controller
{
    private $candidate_form;
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );
    public function __construct()
    {
        parent::__construct();
        Session::put('url.intended', URL::full());
    }

    public function getTryExam(Request $request){
        $url = $this->url;
        $url_source_try = config('site.url_source_try');
        $game_token = $request->input('token');
        $member_id = $request->input('member_id');
        $linkaudio = '/res/sound/';
        $linkhome = $url;
        $linkimg = 'http://static.quiz2.vnedutech.vn';
        try {
            $linkimg = config('app.static_quiz_url');
        } catch (\Throwable $th) {
            //throw $th;
        }
        $linkquest = 'http://quiz2.vnedutech.vn/json/contest/73/399_file.json?v=1558949709';
        $url = $url_source_try . '/index.php?game_token=' . $game_token  . '&linkaudio=' . $linkaudio . '&linkhome=' . $linkhome  . '&linkimg=' . $linkimg . '&linkquest=' . $linkquest ;
        $data = [
            'url' => $url
        ];
      return view('VNE-HOCVALAMTHEOBAC::modules.contest.index',$data);
    }

    public function getRealExam(Request $request){
      $url = $this->url;
      $url_source_real = config('site.url_source_real');
      $game_token = $request->input('token');
      $member_id = $request->input('member_id');
      $linkresult = $url . '/ket-qua-thi-sinh?member_id=' . $member_id;
      $linkaudio = '/res/sound/';
      $linkhome = $url;
      $ip_port = 'http://contest-assd.vnedutech.vn/api/v1/';
      $linkimg = 'http://static.quiz2.vnedutech.vn/public';
      try {
        $linkimg = config('app.static_quiz_url') . '/public';
      } catch (\Throwable $th) {
        //throw $th;
      }
      $linkquest = 'http://quiz2.vnedutech.vn/json/contest/5/9_file.json?v=1539684969';
      $test = 'false';
      $m_level = '3';
      $type = '2';
      $contest_id = 14;
      $url = $url_source_real . '/index.php?game_token=' . $game_token . '&linkresult=' 
            . $linkresult . '&linkaudio=' . $linkaudio . '&linkhome=' . $linkhome . '&ip_port=' . $ip_port 
            . '&linkimg=' . $linkimg . '&linkquest=' . $linkquest . '&test=' . $test . '&m_level=' 
            . $m_level . '&type=' . $type. '&contest_id=' . $contest_id;
      $data = [
        'url' => $url
      ];
      return view('VNE-HOCVALAMTHEOBAC::modules.contest.index',$data);
    }
}
