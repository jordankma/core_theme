<?php

namespace Vne\Mail\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Vne\Mail\App\Repositories\TmailRepository;
use Vne\Mail\App\Models\Tmail;

use Vne\Mail\App\Repositories\GmailRepository;
use Vne\Mail\App\Models\Gmail;

use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator;

class SentController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );
    private $domain_get_data = 'http://cuocthi.vnedutech.vn';
    public function __construct(TmailRepository $tmailRepository,GmailRepository $gmailRepository)
    {
        parent::__construct();
        $this->tmail = $tmailRepository;
        $this->gmail = $gmailRepository;
    }

    public function createHddtw()
    {
        $list_province = array();
        try {
            $list_province = json_decode(file_get_contents($this->domain_get_data .'/resource/dev/get/vne/getallprovince'),true);
        } catch (\Throwable $th) {
            //throw $th;
        }
        $data = [
            'list_province' => $list_province
        ];
        return view('VNE-MAIL::modules.mail.sent.hddtw', $data);
    }
}
