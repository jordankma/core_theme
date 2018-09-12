<?php

namespace Dhcd\Api\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\AController as Controller;
use Dhcd\Api\App\Http\Controllers\Traits\Events;
use Dhcd\Api\App\Http\Controllers\Traits\News;
use Dhcd\Api\App\Http\Controllers\Traits\Forum;
use Dhcd\Api\App\Http\Controllers\Traits\Menu;
use Dhcd\Api\App\Http\Controllers\Traits\Member;
use Dhcd\Api\App\Http\Controllers\Traits\Setting;
use Dhcd\Api\App\Http\Controllers\Traits\Document;
use Dhcd\Api\App\Http\Controllers\Traits\Logsent;
use Dhcd\Api\App\Http\Controllers\Traits\Search;
use Validator;

class GlobalController extends Controller
{
    use Events, News, Forum, Menu, Member, Setting, Document, Logsent, Search;

    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );

    public function get(Request $request, $route_hash)
    {
        $encrypted = $this->my_simple_crypt( 'dev/get/config-text?time='.time()*1000, 'e' );
        $decrypted = $this->my_simple_crypt( $route_hash, 'd' );
        $parts = parse_url($decrypted);

//        echo $encrypted.'<br>';
//        echo $decrypted.'<br>';die;

        $query = [];
        if (count($parts) > 0) {
            if (isset($parts['query'])) {
                parse_str($parts['query'], $query);
            }

            $request->merge($query);
            $validator = Validator::make($request->all(), [
                'time' => 'required|numeric'
//                'token' => 'required'
            ], $this->messages);

            if (!$validator->fails()) {

                if ((time() * 1000 - $request->input('time')) < 28800000) { //5000
                    switch ($parts['path']) {
                        case 'dev/get/test': {
                            return $this->getTest();
                        }
                        case 'dev/get/spliter': {
                            return $this->getSpliter($request);//ok
                        }
                        case 'dev/get/session-seat': {
                            return $this->getSessionSeat();//ok
                        }
                        case 'dev/get/domain-api': {
                            return $this->getDomainApi();//ok
                        }
                        case 'dev/get/config-text': {
                            return $this->getConfigText();//ok
                        }
                        case 'dev/get/app-version': {
                            return $this->getVersion();//ok
                        }
                        case 'dev/get/seat': {
                            return $this->getSeat($request);//ok
                        }
                        case 'dev/get/search': {
                            return $this->getSearch($request);//ok
                        }
                        case 'dev/get/hotel': {
                            return $this->getHotel($request);//ok
                        }
                        case 'dev/get/hotels': {
                            return $this->getHotels();//ok
                        }
                        case 'dev/get/car': {
                            return $this->getCar($request);//ok
                        }
                        case 'dev/get/events': {
                            return $this->getEvents();//ok
                        }
                        case 'dev/get/member-group': {
                            return $this->getMemberGroup($request);//ok
                        }
                        case 'dev/get/member-by-group': {
                            return $this->getMemberByGroup($request);//ok
                        }
                        case 'dev/get/menu': {
                            return $this->getMenu();//ok
                        }
                        case 'dev/get/menu-home': {
                            return $this->getMenuHome();//ok
                        }
                        case 'dev/get/menu-member': {
                            return $this->getMenuMember();//ok
                        }
                        case 'dev/get/files/menu': {
                            return $this->getMenuDocument();//ok
                        }
                        case 'dev/get/files/all': {
                            return $this->getAllDocument();//ok
                        }
                        case 'dev/get/menu/all_files': {
                            return $this->getMenuAll($request);//ok
                        }
                        case 'dev/get/files/document': {
                            return $this->getFilesDocument($request);//ok
                        }
                        case 'dev/get/files/detail': {
                            return $this->getFilesDetail($request);//ok
                        }
                        case 'dev/get/getuserinfo': {
                            return $this->getUserInfo($request);
                        }
                        case 'dev/get/getlogsent': {
                            return $this->getLogSent($request);
                        }
                        case 'dev/get/getlogsent/detail': {
                            return $this->getLogSentDetail($request);
                        }
                    }
                }
            }
        }

        $data = '{
                    "success" : false,
                    "message" : "Ohh!"
                }';
        return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
    }

    function is_url($uri){
        if(preg_match( '/^(http|https):\\/\\/[a-z0-9_]+([\\-\\.]{1}[a-z_0-9]+)*\\.[_a-z]{2,5}'.'((:[0-9]{1,5})?\\/.*)?$/i' ,$uri)){
            return $uri;
        }
        else{
            return false;
        }
    }
}