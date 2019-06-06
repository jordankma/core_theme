<?php

namespace Vne\Hocvalamtheobac\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\MController as Controller;


use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator,Datetime,Session,URL,Schema;
use GuzzleHttp\Client;
use Vne\Hocvalamtheobac\App\ApiHash;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Cache;
class SearchController extends Controller
{
    protected $secret_key = '8bgCi@gsLbtGhO)1';
    protected $secret_iv = ')FQKRL57zFYdtn^!';
    protected $url_api_prefix;
    private $candidate_form;
    private $result_form;
    private $rank_board;
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );
    function setUrlApiPrefix(){
      $this->url_api_prefix = config('app.url').config('site.api_prefix');   
    }
    function setJsonCandidateForm(){
      try {
        // if (Cache::has('candidate_form')) {
        //   $this->candidate_form = Cache::get('candidate_form');
        // } else {
        //   $this->candidate_form = file_get_contents($this->url . '/api/contest/get/load_form?type=candidate');
        //   Cache::put('candidate_form', $this->candidate_form,1440);
        // } 
        $this->candidate_form = file_get_contents($this->url . '/api/contest/get/load_form?type=candidate');
      } catch (\Throwable $th) {
        //throw $th;
      }  
    }
    function setJsonResultForm(){
      try {
        // if (Cache::has('result_form')) {
        //   $this->result_form = Cache::get('result_form');
        // } else {
        //   $this->result_form = file_get_contents($this->url .'/api/contest/get/load_form?type=result');
        //   Cache::put('result_form', $this->result_form,1440);
        // }
        $this->result_form = file_get_contents($this->url .'/api/contest/get/load_form?type=result');
      } catch (\Throwable $th) {
        //throw $th;
      }
    }
    function setJsonRankBoard(){
      try {
        // if (Cache::has('rank_board')) {
        //   $this->rank_board = Cache::get('rank_board');
        // } else {
        //   $this->rank_board = file_get_contents($this->url .'/api/contest/get/rank_board');
        //   Cache::put('rank_board', $this->rank_board,15);
        // }
        $this->rank_board = file_get_contents($this->url .'/api/contest/get/rank_board');
      } catch (\Throwable $th) {
        //throw $th;
      }
    }
    public function __construct()
    {
        parent::__construct();
        Session::put('url.intended', URL::full());
        $this->setUrlApiPrefix();
    }

    public function listMember(Request $request){
        $target = [];
        if(Cache::tags(config('site.cache_tag'))->has('contest_target')){
            $target = Cache::tags(config('site.cache_tag'))->get('contest_target');
        }
        else {
            try {
                $target = file_get_contents($this->url . '/api/contest/get/contest_target');
                if(!empty($target)){
                    $target = json_decode($target);
                    if(!empty($target->data)){
                        $target = $target->data;
                        Cache::tags(config('site.cache_tag'))->forever('contest_target', $target);
                    }
                }

            } catch (\Exception $e) {

            }
        }

      $list_setting = $this->list_setting;
      $open_search = isset($list_setting['open_search']) ? $list_setting['open_search'] : '';
      $data = [
        'open_search' => $open_search
      ];
      if($open_search == 'on'){
        return view('VNE-HOCVALAMTHEOBAC::modules.search.search_member', $data);  
      }

      $this->setJsonCandidateForm();
      $url = $this->url;
      $params = $request->all();
      $params['page'] = $request->has('page') ? $request->input('page') : 1;
      //get form search
      $candidate_form = $this->candidate_form;
      $candidate_form_arr = json_decode($candidate_form,true);
      $form_data = $candidate_form_arr['data']['load_default'];
      // dd($candidate_form_arr['data']);
      $target_data =  !empty($candidate_form_arr['data']['auto_load'])?$candidate_form_arr['data']['auto_load'][0]['form_data']:null;
      $html = view('VNE-HOCVALAMTHEOBAC::modules.search._render_input', compact('form_data'));
      $form_search = $html->render();
      //end
      $list_member = file_get_contents($url . '/api/contest/get/search_candidate?'. http_build_query($params));
      $list_member = json_decode($list_member, true);
      $currentPage = LengthAwarePaginator::resolveCurrentPage();
      $collection = new Collection($list_member['data']);
      $perPage = 20;
      $paginatedSearchResults= new LengthAwarePaginator($collection, $list_member['total'], $perPage, $currentPage,['url' => route('frontend.exam.list.member'),'path' => 'danh-sach-thi-sinh?'. http_build_query($params)]);
      $headers = $list_member['headers'];
      // dd($target_data);
      $data = [
        'paginator' => $paginatedSearchResults,
        'form_search' => $form_search,
        'headers' => $headers,
        'params' => $params,
        'open_search' => $open_search,
        'target' => $target,
        'target_data' => $target_data,
          'link_limit' => 7
      ];
      return view('VNE-HOCVALAMTHEOBAC::modules.search.search_member', $data);
    }

    public function listResult(Request $request){
      //check dong search khong
      $list_setting = $this->list_setting;
      $open_search = isset($list_setting['open_search']) ? $list_setting['open_search'] : '';
      $data = [
        'open_search' => $open_search
      ];
      if($open_search == 'on'){
        return view('VNE-HOCVALAMTHEOBAC::modules.search.search_member', $data);  
      }
      //end
      self::setJsonResultForm();
      $url = $this->url;
      $params = $request->all();
      $params['page'] = $request->has('page') ? $request->input('page') : 1;
      //get form search
      $result_form = $this->result_form;
      $result_form_arr = json_decode($result_form,true);
      $form_data = $result_form_arr['data']['load_default'];
      $target_data =  !empty($result_form_arr['data']['auto_load'])?$result_form_arr['data']['auto_load'][0]['form_data']:null;
      $form_search = '';
      if(!empty($form_data)){
        $html = view('VNE-HOCVALAMTHEOBAC::modules.search._render_input', compact('form_data','params'));
        $form_search = $html->render();
      }
      //end
      $list_member = file_get_contents($url . '/api/contest/get/search_contest_result?' . http_build_query($params));
      $list_member = json_decode($list_member, true);
      $currentPage = LengthAwarePaginator::resolveCurrentPage();
      $collection = new Collection($list_member['data']);
      $perPage = 20;
      unset($params['page']);
      $paginatedSearchResults = new LengthAwarePaginator($collection, $list_member['total'], $perPage, $currentPage,['url' => route('frontend.exam.list.result'),'path' => 'ket-qua?'. http_build_query($params)]);
      $list_member_foreach = array();
      $arr_temp = array();
      $arr_temp_time = array();
      if(!empty($paginatedSearchResults)){
        foreach ($paginatedSearchResults as $key => $value) {
          if(!in_array($value[2],$arr_temp)){
            $list_member_foreach[] = $value;
            $arr_temp[] = $value[2] . '-' . $value[count($value)-1];
          }
        }
      }
      
      $headers = $list_member['headers'];
      // dd($target_data);
      $data = [
        'paginator' => $paginatedSearchResults,
        'form_search' => $form_search,
        'params' => $params,
        'headers' => $headers,
        'list_member_foreach' => $list_member_foreach,
        'open_search' => $open_search,
        'target_data' => $target_data,
          'link_limit' => 7
      ];
      return view('VNE-HOCVALAMTHEOBAC::modules.search.search_result',$data);
    }

    public function getTop(Request $request,$type = 'register')
    {
        $data_child_params =
            ($request->has('data_child_params') && $request->input('data_child_params'))
                ? $request->input('data_child_params') : 'province';
        $target = $request->target ?? null;
        $title = '';
        $url = $this->url;
        $page = $request->has('page') ? $request->input('page') : 1;
        $url_get_by_page = $request->url() . '?data_child_params=' . $data_child_params;
        if (Cache::tags([config('site.cache_tag'), 'top_register'])->has($data_child_params . '_' . $target)) {
            $data_cache = Cache::tags([config('site.cache_tag'), 'top_register'])->get($data_child_params . '_' . $target);
                $data_page = $data_cache[$page] ?? [];
        }
        else {
            $data_cache = [];
            $this->setJsonRankBoard();
            //url get by page

            if (!empty($target)) {
                $url_get_by_page .= '&target=' . $target;
            }
            try {
                $rank_board = json_decode($this->rank_board);
            } catch (\Throwable $th) {
                //throw $th;
                return redirect()->route('index');
            }
            if ($type == 'register') {
                $list_data = $rank_board->data[0] ?? [];
            }
            elseif ($type == 'candidate') {
                $list_data = $rank_board->data[1] ?? [];
            }
            $title = $list_data->title;
            $list_top = $list_data->data_child;
            for ($i = 1;$i <= 10;$i++){
                $data_cache[$i] = [
                    'data_table' => self::getDataTable($list_top, $data_child_params, $i, $target),
                    'data_header' => self::getDataHeader($list_top, $data_child_params, $i),
                    'title' => $title,
                    'list_top' => $list_top,
                ];
            }
            Cache::tags([config('site.cache_tag'), 'top_register'])->put($data_child_params . '_' . $target,$data_cache,7200);
            $data_page = $data_cache[$page];
        }

        $data = [
            'title' => $data_page['title'],
            'type' => $type,
            'params' => $request->all(),
            'list_top' => $data_page['list_top'],
            'data_table' => $data_page['data_table'],
            'page' => $page,
            'data_child_params' => $data_child_params,
            'url_get_by_page' => $url_get_by_page,
            'data_header' => $data_page['data_header']
        ];
        return view('VNE-HOCVALAMTHEOBAC::modules.search.rating',$data);
    }

    public function resultMember(Request $request){
      $url = $this->url;
      $member_id = $request->input('member_id');
      $result_id = $request->input('result_id');
      $headers = array();
      $data = [];
      $user_info = [];
      try {
          $data_member = file_get_contents($url . '/api/contest/get/contest_result?user_id=' . $member_id.'&result_id='.$result_id);
          $data_member = json_decode($data_member);
          $headers = isset($data_member->headers) ? $data_member->headers : $headers;
          $data = $data_member->data;
          $user_info = $data_member->user_info;
      }
      catch (\Exception $e){

      }
      $data = [
        'headers' => $headers,  
        'data' => $data,  
        'user_info' => $user_info  
      ];
      return view('VNE-HOCVALAMTHEOBAC::modules.search.result_member',$data);    
    }
    function getDataTable($list_top, $data_child_params, $page,$target=null){
        $data_table = array();
        if(!empty($list_top)){
            foreach ($list_top as $key => $value) {
                if( $value->params == $data_child_params){
                    $api = $value->api;
                    if(!empty($target)){
                        $url_api_get_data_table = $api . '&page=' . $page . '&top=20&target='.$target;
                    }
                    else{
                        $url_api_get_data_table = $api . '&page=' . $page;
                    }

                    $data_table = file_get_contents($url_api_get_data_table);
                }
            }
        }
        return json_decode($data_table);
    }

    function getDataHeader($list_top, $data_child_params, $page){
      $data_header = array();
      if(!empty($list_top)){
        foreach ($list_top as $key => $value) {
          if( $value->params == $data_child_params){
            $data_header = $value->table_header;
          }    
        }
      }
      return $data_header;
    }
    
}
