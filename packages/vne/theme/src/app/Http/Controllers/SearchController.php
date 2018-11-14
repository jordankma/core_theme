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
    public function __construct()
    {
        parent::__construct();
        Session::put('url.intended', URL::full());
        $this->setUrlApiPrefix();
        $this->setJsonCandidateForm();
        $this->setJsonResultForm();
    }

    public function listMember(){
      $candidate_form = $this->candidate_form;
      $candidate_form_arr = json_decode($candidate_form,true);
      $form_data = $candidate_form_arr['data']['load_default'];
      $html = view('VNE-THEME::modules.search._render_input', compact('form_data'));
      $form_search = $html->render();
      $url = $this->url;
      $params = [
          'table_id' => !empty($request->table_id)?$request->table_id: '',
          'u_name' => !empty($request->u_name)?$request->u_name: '',
          'name' => !empty($request->name)?$request->name: '',
          'city_id' => !empty($request->city_id)?$request->city_id: '',
          'district_id' => !empty($request->district_id)?$request->district_id: '',
          'school_id' => !empty($request->school_id)?$request->school_id: '',
          'class_id' => !empty($request->class_id)?$request->class_id: '',
          'topic_id' => !empty($request->topic_id)?$request->topic_id: '',
          'page'=> !empty($request->page)?$request->page:1
      ];
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
      //get form search
      $candidate_form = $this->candidate_form;
      $candidate_form_arr = json_decode($candidate_form,true);
      $form_data = $candidate_form_arr['data']['load_default'];
      $html = view('VNE-THEME::modules.search._render_input', compact('form_data'));
      $form_search = $html->render();

      $url = $this->url;
      $params = [
          'table_id' => !empty($request->table_id)?$request->table_id: '',
          'u_name' => !empty($request->u_name)?$request->u_name: '',
          'name' => !empty($request->name)?$request->name: '',
          'city_id' => !empty($request->city_id)?$request->city_id: '',
          'district_id' => !empty($request->district_id)?$request->district_id: '',
          'school_id' => !empty($request->school_id)?$request->school_id: '',
          'class_id' => !empty($request->class_id)?$request->class_id: '',
          'topic_id' => !empty($request->topic_id)?$request->topic_id: '',
          'page'=> !empty($request->page)?$request->page:1
      ];
      $list_member = file_get_contents('http://timhieubiendao.daknong.vn/admin/api/contest/search_contest_result?'. http_build_query($params));
      $list_member = json_decode($list_member, true);
      $currentPage = LengthAwarePaginator::resolveCurrentPage();
      $collection = new Collection($list_member['data']);
      $perPage = 20;
      $paginatedSearchResults= new LengthAwarePaginator($collection, $list_member['total'], $perPage, $currentPage,['url' => route('frontend.exam.list.result'),'path' => 'ket-qua?'. http_build_query($params)]);
      $data = [
        'list_member' => $paginatedSearchResults,
        'form_search' => $form_search,
        'params' => $params
      ];
      return view('VNE-THEME::modules.search.search_result',$data);
    }

    public function getTopResult(){
      $title = "Top thí sinh thi";
      $url = $this->url;
      $list_top_thi_sinh_da_thi_tinh = file_get_contents($url . 'api/contest/get/top/candidate?top_type=province&top=all&page=1&table_id=&round_id=&topic_id=');
            
      $list_top_thi_sinh_da_thi_truong = file_get_contents($url . 'api/contest/get/top/candidate?top_type=school&top=100&page=1&table_id=&round_id=&topic_id=');
      $data = [
        'title' => $title,
        'list_top_thi_sinh_da_thi_tinh' => json_decode($list_top_thi_sinh_da_thi_tinh),
        'list_top_thi_sinh_da_thi_truong' => json_decode($list_top_thi_sinh_da_thi_truong)
      ];
      return view('VNE-THEME::modules.search.rating',$data);
    }
    public function getTopRegister(){
      $title = "Top thí sinh đăng ký";
      $url = $this->url;
      $list_top_thi_sinh_dang_ky_tinh = file_get_contents($url . 'api/contest/get/top/register?top_type=province&top=all&page=1&table_id=');
      $list_top_thi_sinh_dang_ky_truong = file_get_contents($url . 'api/contest/get/top/register?top_type=school&top=100&page=1&table_id=');
      $data = [
        'title' => $title,
        'list_top_thi_sinh_dang_ky_tinh' => json_decode($list_top_thi_sinh_dang_ky_tinh),
        'list_top_thi_sinh_dang_ky_truong' => json_decode($list_top_thi_sinh_dang_ky_truong)
      ];
      return view('VNE-THEME::modules.search.rating_register',$data);
    }

}
