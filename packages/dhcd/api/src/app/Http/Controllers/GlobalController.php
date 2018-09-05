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
        $encrypted = $this->my_simple_crypt( 'dev/get/search?time='.time()*1000 .'&keyword=lê', 'e' );
        $decrypted = $this->my_simple_crypt( $route_hash, 'd' );
        $parts = parse_url($decrypted);

       // echo $encrypted.'<br>';
       // echo $decrypted.'<br>';die;

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

            $validatorLogin = Validator::make($request->all(), [
                'time' => 'required|numeric'
            ], $this->messages);

            if (!$validator->fails()) {

//                $getUser = app('Adtech\Api\App\Http\Controllers\Auth\LoginController')->me();
//                $userInfo = json_decode($getUser->content());

                if ((time() * 1000 - $request->input('time')) < 6000000) { //5000
                    switch ($parts['path']) {
                        case 'dev/get/test': {
                            return $this->getTest();
                        }
                        case 'dev/get/session-seat': {
                            return $this->getSessionSeat();
                        }
                        case 'dev/get/domain-api': {
                            return $this->getDomainApi();
                        }
                        case 'dev/get/config-text': {
                            return $this->getConfigText();
                        }
                        case 'dev/get/app-version': {
                            return $this->getVersion();
                        }
                        case 'dev/get/seat': {
                            return $this->getSeat($request);
                        }
                        case 'dev/get/search': {
                            return $this->getSearch($request);
                        }
                        case 'dev/get/hotel': {
                            return $this->getHotel($request);
                        }
                        case 'dev/get/hotels': {
                            return $this->getHotels();
                        }
                        case 'dev/get/car': {
                            return $this->getCar($request);
                        }
                        case 'dev/get/events': {
                            return $this->getEvents();
                        }
//                        case 'dev/get/news': {
//                            return $this->getNews($request);
//                        }
//                        case 'dev/get/news-home': {
//                            return $this->getNewshome($request);
//                        }
//                        case 'dev/get/detail-news': {
//                            return $this->getNewsdetail($request);
//                        }
//                        case 'dev/get/forum': {
//                            return $this->getForum($request);
//                        }
                        case 'dev/get/member-group': {
                            return $this->getMemberGroup($request);
                        }
                        case 'dev/get/member-by-group': {
                            return $this->getMemberByGroup($request);
                        }
//                        case 'dev/get/member-by-category': {
//                            return $this->getMemberByCategory($request);
//                        }
                        case 'dev/get/menu': {
                            return $this->getMenu();
                        }
                        case 'dev/get/menu-home': {
                            return $this->getMenuHome();
                        }
                        case 'dev/get/menu-member': {
                            return $this->getMenuMember();
                        }
                        case 'dev/get/files/menu': {
                            return $this->getMenuDocument();
                        }
                        case 'dev/get/files/all': {
                            return $this->getAllDocument();
                        }
                        case 'dev/get/files/document': {
                            return $this->getFilesDocument($request);
                        }
                        case 'dev/get/files/detail': {
                            return $this->getFilesDetail($request);
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
                        case 'dev/get/logout': {
                            return app('Adtech\Api\App\Http\Controllers\Auth\LoginController')->logout();
                        }
                        case 'dev/get/refresh': {
                            return app('Adtech\Api\App\Http\Controllers\Auth\LoginController')->refresh();
                        }
                    }
                }
//                } else {
//                    return response($getUser->content())->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
//                }
            } elseif (!$validatorLogin->fails()) {
                if ((time() * 1000 - $request->input('time')) < 6000000) {
                    switch ($parts['path']) {
                        case 'dev/post/login': {
                            return app('Adtech\Api\App\Http\Controllers\Auth\LoginController')->login();
                        }
                        case 'dev/get/version-nav': {
                            return $this->getVersionNav();
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
}