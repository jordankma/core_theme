<?php

namespace Vne\Hocvalamtheobac\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\MController as Controller;


use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator,Datetime,Session,URL,Schema;

use Vne\Banner\App\Models\Banner;
use Vne\Contact\App\Models\Contact;
use Vne\News\App\Models\News;
use Vne\Member\App\Models\Member;
use Vne\Timeline\App\Models\Timeline;
use Vne\Companionunit\App\Models\Companionunit;
use Vne\News\App\Repositories\NewsRepository;
use GuzzleHttp\Client;
use Vne\Hocvalamtheobac\App\ApiHash;

class ContactController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );
    
    
    public function __construct( NewsRepository $newsRepository)
    {
        parent::__construct();
        Session::put('url.intended', URL::full());
    }

    
    public function showContact(){
      return view('VNE-HOCVALAMTHEOBAC::modules.contact.contact');
    }

    public function saveContact(Request $request){
        $contact = new Contact();
        $contact->name = $request->input('name');
        $contact->email = $request->input('email_contact');
        $contact->content = $request->input('content');
        $contact->created_at = new Datetime();
        if($contact->save()) {
            return view('VNE-HOCVALAMTHEOBAC::modules.contact.contact')->with('thongbao','Gửi liên hệ thành công');
        }

    }
}
