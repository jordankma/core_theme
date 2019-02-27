<?php

namespace Vne\Hocvalamtheobac\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\MController as Controller;


use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator,Datetime,Session,URL,Schema;
use GuzzleHttp\Client;
use Vne\Hocvalamtheobac\App\ApiHash;

class ExamController extends Controller
{
    protected $secret_key = '8bgCi@gsLbtGhO)1';
    protected $secret_iv = ')FQKRL57zFYdtn^!';
    protected $url_api_prefix;
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );
    function setUrlApiPrefix(){
      $this->url_api_prefix = config('app.url').config('site.api_prefix');   
    }

    public function __construct()
    {
        parent::__construct();
        Session::put('url.intended', URL::full());
        $this->setUrlApiPrefix();
    }

    public function listExam(){
        $list_banner = array();
        $data = [
            'list_banner' => $list_banner
        ];
        return view('VNE-HOCVALAMTHEOBAC::modules.index.index');
    }

    public function detailExam(){
        $list_banner = array();
        $data = [
            'list_banner' => $list_banner,
            
        ];
        return view('VNE-HOCVALAMTHEOBAC::modules.index.index');
    }

    public function scheduleExam(){
        $schedule = array();
        try {
            $link_get_schedule = $this->url_api_prefix.'/vne/gettimeline';
            
            $schedule = file_get_contents($link_get_schedule);
            $schedule = json_decode($schedule)->data;
            // dd($schedule);
        } catch (\Throwable $th) {
            //throw $th;
        } 
        $data = [
            'schedule' => $schedule
        ];
        return view('VNE-HOCVALAMTHEOBAC::modules.exam.schedule',$data);
    }
}
