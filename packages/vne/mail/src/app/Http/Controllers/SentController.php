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

    public function __construct(TmailRepository $tmailRepository,GmailRepository $gmailRepository)
    {
        parent::__construct();
        $this->tmail = $tmailRepository;
        $this->gmail = $gmailRepository;
    }

    public function manage()
    {
        return view('VNE-MAIL::modules.mail.demo.manage');
    }
}
