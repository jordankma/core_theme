<?php

namespace Vne\Contact\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Vne\Contact\App\Repositories\ContactRepository;
use Vne\Contact\App\Models\Contact;
use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator,Datetime;
use Adtech\Core\App\Models\Domain;
use Adtech\Core\App\Models\Setting;
class ApiContactController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );

    public function __construct(ContactRepository $contactRepository)
    {
        parent::__construct();
        $this->contact = $contactRepository;
    }
    public function getTextContact(Request $request) {
        $data = [
            'success' => false,
            'message' => 'Lấy text form liên hệ thất bại'
        ];
        $domain_id = 0;
        $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : null;
        if ($host) {
            $domain = Domain::where('name', $host)->first();
            if (null != $domain) {
                $this->currentDomain = $domain;
                $domain_id = $domain->domain_id;
            }
        }
        $this->domainDefault = $domain_id;
        if(isset($_GET["domain_id"])) {
            $domain_id = $_GET["domain_id"];
        }
        $settings = Setting::where('domain_id', $this->domainDefault)->get();
        $info_contact = '';
        if (count($settings) > 0) {
            foreach ($settings as $setting) {
                switch ($setting->name) {
                    case 'info_page_contact_mobile':
                        $info_contact = base64_encode($setting->value);
                        break;
                }
            }
        }
        $data = [
            'success' => true,
            'message' => 'Lấy text form liên hệ thành công',
            'data' => $info_contact
        ];
        return response(json_encode($data))->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
    }
    public function postSendContact(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email_contact' => 'required',
            'content' => 'required',
        ], $this->messages);
        if (!$validator->fails()) {
            $data = [
                'success' => false,
                'message' => 'Gửi liên hệ thất bại'
            ];
            $contact = new Contact();
            $contact->name = $request->input('name');
            $contact->email = $request->input('email_contact');
            $contact->content = $request->input('content');
            $contact->created_at = new Datetime();
            if($contact->save()){
                $data = [
                    'success' => true,
                    'message' => 'Gửi liên hệ thành công'
                ];
            }
            return response(json_encode($data))->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
        } else{
            return $validator->messages();
        }
    }
}
