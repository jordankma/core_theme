<?php

namespace Vne\Theme\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\MController as Controller;


use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator,Datetime,Session,URL,Schema;
use GuzzleHttp\Client;
use Vne\Theme\App\ApiHash;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
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
      $this->candidate_form = file_get_contents($this->url . '/api/contest/get/load_form?type=candidate');  
    }
    function setJsonResultForm(){
      $this->result_form = file_get_contents($this->url .'/api/contest/get/load_form?type=result');  
    }
    function setJsonRankBoard(){
      $this->rank_board = file_get_contents($this->url .'/api/contest/get/rank_board');  
    }
    public function __construct()
    {
        parent::__construct();
        Session::put('url.intended', URL::full());
        $this->setUrlApiPrefix();
        $this->setJsonCandidateForm();
        $this->setJsonResultForm();
        $this->setJsonRankBoard();
    }

    public function listMember(Request $request){
      $url = $this->url;
      $params = $request->all();
      $params['page'] = $request->has('page') ? $request->input('page') : 1;
      //get form search
      $candidate_form = $this->candidate_form;
      $candidate_form_arr = json_decode($candidate_form,true);
      $form_data = $candidate_form_arr['data']['load_default'];
      $html = view('VNE-THEME::modules.search._render_input', compact('form_data'));
      $form_search = $html->render();
      //end
      $list_member = file_get_contents($url . '/api/contest/get/search_candidate?'. http_build_query($params));
      $list_member = json_decode($list_member, true);
      $currentPage = LengthAwarePaginator::resolveCurrentPage();
      $collection = new Collection($list_member['data']);
      $perPage = 20;
      $paginatedSearchResults= new LengthAwarePaginator($collection, $list_member['total'], $perPage, $currentPage,['url' => route('frontend.exam.list.member'),'path' => 'danh-sach-thi-sinh?'. http_build_query($params)]);
      $data = [
        'list_member' => $paginatedSearchResults,
        'form_search' => $form_search,
        'params' => $params
      ];
      return view('VNE-THEME::modules.search.search_member', $data);
    }

    public function listResult(Request $request){
      $url = $this->url;
      $params = $request->all();
      $params['page'] = $request->has('page') ? $request->input('page') : 1;
      //get form search
      $candidate_form = $this->candidate_form;
      $candidate_form_arr = json_decode($candidate_form,true);
      $form_data = $candidate_form_arr['data']['load_default'];
      $html = view('VNE-THEME::modules.search._render_input', compact('form_data'));
      $form_search = $html->render();
      //end
      $list_member = file_get_contents($url . '/api/contest/get/search_contest_result?'. http_build_query($params));
      $list_member = json_decode($list_member, true);
      $currentPage = LengthAwarePaginator::resolveCurrentPage();
      $collection = new Collection($list_member['data']);
      $perPage = 20;
      $paginatedSearchResults = new LengthAwarePaginator($collection, $list_member['total'], $perPage, $currentPage,['url' => route('frontend.exam.list.result'),'path' => 'ket-qua?'. http_build_query($params)]);
      $headers = $list_member['headers'];
      $data = [
        'list_member' => $paginatedSearchResults,
        'form_search' => $form_search,
        'params' => $params,
        'headers' => $headers
      ];
      return view('VNE-THEME::modules.search.search_result',$data);
    }

    public function getTop(Request $request,$type){
      $title = '';
      $url = $this->url;
      $type = $type;
      $page = $request->has('page') ? $request->input('page') : 1;
      $data_child_params = 
        ($request->has('data_child_params') && $request->input('data_child_params')) 
        ? $request->input('data_child_params') : 'school';
      //url get by page
      $url_get_by_page = $request->url() . '?top_type=' . $data_child_params;
      try {
        $rank_board = json_decode($this->rank_board);
        $list_top_thi_sinh_dang_ky = $rank_board->data[0];
        $list_top_thi_sinh_da_thi = $rank_board->data[1];    
      } catch (\Throwable $th) {
        //throw $th;
        return redirect()->route('index');
      }
      
      if($type=='register'){
        $title = $list_top_thi_sinh_dang_ky->title;
        $list_top = $list_top_thi_sinh_dang_ky->data_child;
        $data_table = self::getDataTable($list_top, $data_child_params, $page);
      } 
      elseif($type=='candidate'){
        $title = $list_top_thi_sinh_da_thi->title;
        $list_top = $list_top_thi_sinh_da_thi->data_child;
        $data_table = self::getDataTable($list_top, $data_child_params, $page);
      }
      $data = [
        'title' => $title,
        'type' => $type,
        'list_top' => $list_top,
        'data_table' => $data_table,
        'page' => $page,
        'data_child_params' => $data_child_params,
        'url_get_by_page' => $url_get_by_page
      ];
      return view('VNE-THEME::modules.search.rating',$data);
    }

    function getDataTable($list_top, $data_child_params, $page){
      $data_table = array();
      if(!empty($list_top)){
        foreach ($list_top as $key => $value) {
          if( $value->params == $data_child_params){
            $api = $value->api;
            $url_api_get_data_table = $api . '&page=' . $page . '&top=20';
            $data_table = file_get_contents($url_api_get_data_table);
          }    
        }
      }
      return json_decode($data_table);
    }
}
