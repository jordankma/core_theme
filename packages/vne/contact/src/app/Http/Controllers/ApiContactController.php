<?php

namespace Vne\Contact\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Vne\Contact\App\Repositories\ContactRepository;
use Vne\Contact\App\Models\Contact;
use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator,Datetime;

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
