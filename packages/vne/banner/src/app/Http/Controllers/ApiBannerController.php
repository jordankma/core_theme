<?php

namespace Vne\Banner\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;

use Vne\Banner\App\Http\Requests\BannerRequest;

use Vne\Banner\App\Repositories\BannerRepository;

use Vne\Banner\App\Models\Banner;
use Vne\Banner\App\Models\Position;

use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator;
use DateTime;
class ApiBannerController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );

    public function __construct(BannerRepository $bannerRepository)
    {
        parent::__construct();
        $this->banner = $bannerRepository;
    }

    public function getListBannerByPositionApi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'position_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            $list_banner = $this->banner->bannerByPosition($request->input('position_id'));
            $data = array();
            if(!empty($list_banner)){
                foreach ($list_banner as $key => $value) {
                    $data[] = [
                        'id' => $value->banner_id,
                        'name' => base64_encode($value->name),
                        'link' => $value->link,
                        'image' => $value->image,
                        'desc' => base64_encode($value->desc),
                        'close_at' => $value->close_at
                    ];
                }
            }
            $data_reponse = [
                'data' => $data,
                'success' => true,
                'message' => 'ok!'
            ];
            return response(json_encode($data_reponse))->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
        } else {
            return $validator->messages();
        }
    }
}
