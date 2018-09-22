<?php

namespace Dhcd\Api\App\Http\Controllers\Traits;

use Dhcd\Member\App\Models\Member as MemberModel;
use Dhcd\Sessionseat\App\Models\Sessionseat;
use Dhcd\Car\App\Models\Car;
use Dhcd\Seat\App\Models\Seat;
use Dhcd\Hotel\App\Models\Hotel;
use Dhcd\Member\App\Models\Group;
use Dhcd\Document\App\Models\DocumentCate;
use Validator,Auth,DB,Hash;
use Cache;

trait Member
{
    public function getCar($request)
    {
        $doan_id = $request->input('doan_id');

        //get cache
        $cache_data = 'data_api_car_' . $doan_id;
        if (Cache::has($cache_data)) {
            $data = Cache::get($cache_data);
        } else {

//            $cache_name = 'car_' . $doan_id;
//            if (Cache::has($cache_name)) {
//                $cars = Cache::get($cache_name);
//            } else {
//                $cars = car::orWhere('doan_id', 'like', $doan_id . ',%')
//                    ->orWhere('doan_id', 'like', '%,' . $doan_id . ',%')
//                    ->orWhere('doan_id', 'like', '%,' . $doan_id)
//                    ->orWhere('doan_id', $doan_id)
//                    ->get();
//                $expiresAt = now()->addMinutes(3600);
//                Cache::put($cache_name, $cars, $expiresAt);
//            }

            $cars = car::orWhere('doan_id', 'like', $doan_id . ',%')
                ->orWhere('doan_id', 'like', '%,' . $doan_id . ',%')
                ->orWhere('doan_id', 'like', '%,' . $doan_id)
                ->orWhere('doan_id', $doan_id)
                ->get();

            $list_car = [];
            if (count($cars) > 0) {
                foreach ($cars as $car) {

                    $arrStaff = json_decode($car->car_staff, true);
                    if (count($arrStaff) > 0) {
                        foreach ($arrStaff as $k => $staff) {

                            $item = new \stdClass();
                            $item->staffname = base64_encode($staff['staffname']);
                            $item->staffpos = base64_encode($staff['staffpos']);
                            $item->phone = base64_encode($staff['phone']);

                            $arrStaff[$k] = $item;
                        }
                    }

                    $item = new \stdClass();
                    $icon_link = ($car->img != '') ? config('site.url_storage') . $car->img : '';
                    $item->img = (self::is_url($car->img)) ? $car->img : $icon_link;
                    $item->note = base64_encode($car->note);
                    $item->car_bs = base64_encode($car->car_bs);
                    $item->car_num = base64_encode($car->car_num);
                    $item->staff = $arrStaff;

                    $list_car[] = $item;
                }
            }

            $data = '{
                    "data": {
                        "list_car": ' . json_encode($list_car) . '
                    },
                    "success" : true,
                    "message" : "ok!"
                }';
            $data = str_replace('null', '""', $data);

            //put cache
            $expiresAt = now()->addDays(5);
            Cache::put($cache_data, $data, $expiresAt);
        }

        return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
    }
    
    public function getHotel($request)
    {
        $doan_id = $request->input('doan_id');

        //get cache
        $cache_data = 'data_api_hotel_' . $doan_id;
        if (Cache::has($cache_data)) {
            $data = Cache::get($cache_data);
        } else {

//            $cache_name = 'hotel_' . $doan_id;
//            if (Cache::has($cache_name)) {
//                $hotels = Cache::get($cache_name);
//            } else {
//                $hotels = Hotel::orWhere('doan_id', 'like', $doan_id . ',%')
//                    ->orWhere('doan_id', 'like', '%,' . $doan_id . ',%')
//                    ->orWhere('doan_id', 'like', '%,' . $doan_id)
//                    ->orWhere('doan_id', $doan_id)
//                    ->get();
//                $expiresAt = now()->addMinutes(3600);
//                Cache::put($cache_name, $hotels, $expiresAt);
//            }

            $hotels = Hotel::orWhere('doan_id', 'like', $doan_id . ',%')
                ->orWhere('doan_id', 'like', '%,' . $doan_id . ',%')
                ->orWhere('doan_id', 'like', '%,' . $doan_id)
                ->orWhere('doan_id', $doan_id)
                ->get();

            $list_hotel = [];
            if (count($hotels) > 0) {
                foreach ($hotels as $hotel) {

                    $arrStaff = json_decode($hotel->hotel_staff, true);
                    if (count($arrStaff) > 0) {
                        foreach ($arrStaff as $k => $staff) {

                            $item = new \stdClass();
                            $item->staffname = base64_encode($staff['staffname']);
                            $item->staffpos = base64_encode($staff['staffpos']);
                            $item->phone = base64_encode($staff['phone']);

                            $arrStaff[$k] = $item;
                        }
                    }

                    $item = new \stdClass();
                    $item->hotel = base64_encode($hotel->hotel);
                    $icon_link = ($hotel->img != '') ? config('site.url_storage') . $hotel->img : '';
                    $item->img = (self::is_url($hotel->img)) ? $hotel->img : $icon_link;
                    $item->note = base64_encode($hotel->note);
                    $item->address = base64_encode($hotel->address);
                    $item->staff = $arrStaff;

                    $list_hotel[] = $item;
                }
            }

            $data = '{
                    "data": {
                        "list_hotel": ' . json_encode($list_hotel) . '
                    },
                    "success" : true,
                    "message" : "ok!"
                }';
            $data = str_replace('null', '""', $data);

            //put cache
            $expiresAt = now()->addDays(5);
            Cache::put($cache_data, $data, $expiresAt);
        }
        return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
    }

    public function getHotels()
    {
        //get cache
        $cache_data = 'data_api_hotels';
        if (Cache::has($cache_data)) {
            $data = Cache::get($cache_data);
        } else {

//            $cache_name = 'hotels';
//            if (Cache::has($cache_name)) {
//                $hotels = Cache::get($cache_name);
//            } else {
//                $hotels = Hotel::all();
//                $expiresAt = now()->addMinutes(3600);
//                Cache::put($cache_name, $hotels, $expiresAt);
//            }

            $hotels = Hotel::all();
            $list_hotel = [];
            if (count($hotels) > 0) {
                foreach ($hotels as $hotel) {

                    $arrStaff = json_decode($hotel->hotel_staff, true);
                    if (count($arrStaff) > 0) {
                        foreach ($arrStaff as $k => $staff) {

                            $item = new \stdClass();
                            $item->staffname = base64_encode($staff['staffname']);
                            $item->staffpos = base64_encode($staff['staffpos']);
                            $item->phone = base64_encode($staff['phone']);

                            $arrStaff[$k] = $item;
                        }
                    }

                    $item = new \stdClass();
                    $item->hotel = base64_encode($hotel->hotel);
                    $icon_link = ($hotel->img != '') ? config('site.url_storage') . $hotel->img : '';
                    $item->img = (self::is_url($hotel->img)) ? $hotel->img : $icon_link;
                    $item->note = base64_encode($hotel->note);
                    $item->address = base64_encode($hotel->address);
                    $item->staff = $arrStaff;

                    $list_hotel[] = $item;
                }
            }

            $data = '{
                    "data": {
                        "list_hotels": ' . json_encode($list_hotel) . '
                    },
                    "success" : true,
                    "message" : "ok!"
                }';
            $data = str_replace('null', '""', $data);

            //put cache
            $expiresAt = now()->addDays(5);
            Cache::put($cache_data, $data, $expiresAt);
        }

        return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
    }

    public function getSeat($request)
    {
        $doan_id = $request->input('doan_id');
        $sessionseat_id = $request->input('sessionseat_id');

        //get cache
        $cache_data = 'data_api_seat' . $doan_id . '_' . $sessionseat_id;
        if (Cache::has($cache_data)) {
            $data = Cache::get($cache_data);
        } else {
//            $cache_name = 'seat_' . $doan_id . '_' . $sessionseat_id;
//            if (Cache::has($cache_name)) {
//                $seats = Cache::get($cache_name);
//            } else {
//                $seats = Seat::where('doan_id', $doan_id)->where('sessionseat_id' , $sessionseat_id)->get();
//                $expiresAt = now()->addMinutes(3600);
//                Cache::put($cache_name, $seats, $expiresAt);
//            }

            $seats = Seat::where('doan_id', $doan_id)->where('sessionseat_id' , $sessionseat_id)->get();
            $list_seat = [];
            if (count($seats) > 0) {
                foreach ($seats as $seat) {

                    $arrStaff = json_decode($seat->seat_staff, true);
                    if (count($arrStaff) > 0) {
                        foreach ($arrStaff as $k => $staff) {

                            $item = new \stdClass();
                            $item->staffname = base64_encode($staff['staffname']);
                            $item->staffpos = base64_encode($staff['staffpos']);
                            $item->phone = base64_encode($staff['phone']);

                            $arrStaff[$k] = $item;
                        }
                    }

                    $item = new \stdClass();
                    $item->seat = base64_encode($seat->seat);
                    $item->note = base64_encode($seat->note);
                    $item->staff = $arrStaff;

                    $list_seat[] = $item;
                }
            }

            $data = '{
                    "data": {
                        "list_seat": '. json_encode($list_seat) .'
                    },
                    "success" : true,
                    "message" : "ok!"
                }';
            $data = str_replace('null', '""', $data);

            //put cache
            $expiresAt = now()->addDays(5);
            Cache::put($cache_data, $data, $expiresAt);
        }

        return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
    }

    public function getSessionSeat()
    {
        //get cache
        $cache_data = 'data_api_session_seat';
        if (Cache::has($cache_data)) {
            $data = Cache::get($cache_data);
        } else {

//            $cache_name = 'session_seat';
//            if (Cache::has($cache_name)) {
//                $sessionSeat = Cache::get($cache_name);
//            } else {
//                $sessionSeat = Sessionseat::all();
//                $expiresAt = now()->addMinutes(3600);
//                Cache::put($cache_name, $sessionSeat, $expiresAt);
//            }

            $sessionSeat = Sessionseat::all();
            $list_session_seat = [];
            if (count($sessionSeat) > 0) {
                foreach ($sessionSeat as $session) {

                    $arrImg = json_decode($session->sessionseat_img, true);
                    if (count($arrImg) > 0) {
                        foreach ($arrImg as $k => $img) {

                            $item = new \stdClass();
                            $icon_link = ($img != '') ? config('site.url_storage') . $img : '';
                            $item->url = (self::is_url($img)) ? $img : $icon_link;

                            $arrImg[$k] = $item;
                        }
                    }

                    $item = new \stdClass();
                    $item->id = $session->sessionseat_id;
                    $item->name = base64_encode($session->sessionseat_name);
                    $item->image = $arrImg;

                    $list_session_seat[] = $item;
                }
            }

            $data = '{
                        "data": {
                            "list_session_seat": '. json_encode($list_session_seat) .'
                        },
                        "success" : true,
                        "message" : "ok!"
                    }';
            $data = str_replace('null', '""', $data);

            //put cache
            $expiresAt = now()->addDays(5);
            Cache::put($cache_data, $data, $expiresAt);
        }
        return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
    }

    public function getMemberGroup($request)
    {
        //get cache
        $cache_data = 'data_api_member_group';
        if (Cache::has($cache_data)) {
            $data = Cache::get($cache_data);
        } else {

//            $cache_name = 'member_group';
//            if (Cache::has($cache_name)) {
//                $memberGroup = Cache::get($cache_name);
//            } else {
//                $memberGroup = Group::all();
//                $expiresAt = now()->addMinutes(3600);
//                Cache::put($cache_name, $memberGroup, $expiresAt);
//            }

            $memberGroup = Group::all();
            $list_member_groups = [];
            if (count($memberGroup) > 0) {
                foreach ($memberGroup as $group) {

                    if ($request->has('type')) {
                        if ($group->type != $request->input('type')) {
                            continue;
                        }
                    }

                    if ($group->group_id == 562) {
                        continue;
                    }

                    $item = new \stdClass();
                    $item->id = $group->group_id;
                    $item->name = base64_encode($group->name);
                    $item->desc = base64_encode($group->desc);
                    $item->alias = base64_encode($group->alias);
                    $icon_link = ($group->image != '') ? config('site.url_storage') . $group->image : '';
                    $item->image = (self::is_url($group->image)) ? $group->image : $icon_link;

                    $list_member_groups[] = $item;
                }

//                usort($list_member_groups, "cmp");

                if (count($list_member_groups) % 2 != 0) {
                    $item = new \stdClass();
                    $item->id = 9999;
                    $item->name = base64_encode('');
                    $item->desc = base64_encode('');
                    $item->alias = base64_encode('');
                    $item->image = '';
                    $list_member_groups[] = $item;
                }
            }

            $data = '{
                    "data": {
                        "list_member_group": ' . json_encode($list_member_groups) . '
                    },
                    "success" : true,
                    "message" : "ok!"
                }';
            $data = str_replace('null', '""', $data);

            //put cache
            $expiresAt = now()->addDays(5);
            Cache::put($cache_data, $data, $expiresAt);
        }

        return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
    }

    public function getMemberByGroup($request)
    {
        if ($request->has('is_category')) {
            $members = [];
            $alias = $request->input('alias');

            //get cache
            $cache_data = 'data_api_member_by_category_' . $alias;
            if (Cache::has($cache_data)) {
                $data = Cache::get($cache_data);
            } else {

//                $cache_name = 'member_by_category_' . $alias;
//                if (Cache::has($cache_name)) {
//                    $members = Cache::get($cache_name);
//                } else {
//                    $category = DocumentCate::where('alias', $alias)->first();
//                    if (null != $category) {
//                        $members = MemberModel::whereHas('documentCate', function ($query) use ($category) {
//                            $query->where('dhcd_document_cate_has_member.document_cate_id', $category->document_cate_id);
//                            $query->where('dhcd_document_cate_has_member.deleted_at', null);
//                        })->get();
//                        $expiresAt = now()->addMinutes(3600);
//                        Cache::put($cache_name, $members, $expiresAt);
//                    }
//                }

                $list_members = [];
                $category = DocumentCate::where('alias', $alias)->first();
                if (null != $category) {
                    $members = json_decode($category->member_json, true);
                    if (count($members) > 0) {
                        foreach ($members as $member) {
                            $data = base64_encode(implode('|', $member));
                            $item = new \stdClass();
                            $item->id = 'json_' . $data;
                            $item->name = base64_encode($member[1]);
                            $item->doan = base64_encode($member[3]);
                            $list_members[] = $item;
                        }
                    }

//                    $members = MemberModel::with('group')->whereHas('documentCate', function ($query) use ($category) {
//                        $query->where('dhcd_document_cate_has_member.document_cate_id', $category->document_cate_id);
//                        $query->where('dhcd_document_cate_has_member.deleted_at', null);
//                    })->get();
                }

//                if (count($members) > 0) {
//                    foreach ($members as $member) {
//
//                        $item = new \stdClass();
//                        $item->id = $member->member_id;
//                        $item->name = base64_encode($member->name);
//                        $icon_link = ($member->avatar != '') ? config('site.url_storage') . $member->avatar : '';
//                        $item->anh_ca_nhan = (self::is_url($member->avatar)) ? $member->avatar : $icon_link;
//                        $item->ten_hien_thi = base64_encode($member->name);
//                        $item->email = base64_encode($member->email);
//                        $item->so_dien_thoai = base64_encode($member->phone);
//                        $item->doan_thanh_nien = base64_encode($member->don_vi);
//                        $item->ngay_vao_dang = base64_encode($member->ngay_vao_dang);
//                        $item->dan_toc = base64_encode($member->dan_toc);
//                        $item->chuc_vu = base64_encode($member->position_current);
//                        $item->ton_giao = base64_encode($member->ton_giao);
//                        $item->trinh_do_ly_luan = base64_encode($member->trinh_do_ly_luan);
//                        $item->trinh_do_chuyen_mon = base64_encode($member->trinh_do_chuyen_mon);
//                        $item->noi_lam_viec = base64_encode($member->address);
//                        $item->doan = '';
//                        if (count($member->group) > 0) {
//                            $item->doan = base64_encode($member->group[0]->name);
//                        }
//
//                        $list_members[] = $item;
//                    }
//                }

                $data = '{
                    "data": {
                        "list_member_by_document_cate": ' . json_encode($list_members) . '
                    },
                    "success" : true,
                    "message" : "ok!"
                }';
                $data = str_replace('null', '""', $data);

                //put cache
                $expiresAt = now()->addDays(5);
                Cache::put($cache_data, $data, $expiresAt);
            }

            return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
        } else {
            $members = [];
            $alias = $request->input('alias');

            //get cache
            $cache_data = 'data_api_member_by_group_' . $alias;
            if (Cache::has($cache_data)) {
                $data = Cache::get($cache_data);
            } else {

//                $cache_name = 'member_by_group_' . $alias;
//                if (Cache::has($cache_name)) {
//                    $members = Cache::get($cache_name);
//                } else {
//                    $group = Group::where('alias', $alias)->first();
//                    if (null != $group) {
//                        $members = MemberModel::whereHas('group', function ($query) use ($group) {
//                            $query->where('dhcd_group_has_member.group_id', $group->group_id);
//                            $query->where('dhcd_group_has_member.deleted_at', null);
//                        })->get();
//                        $expiresAt = now()->addMinutes(3600);
//                        Cache::put($cache_name, $members, $expiresAt);
//                    }
//                }
                $group = Group::where('alias', $alias)->first();
                if (null != $group) {
                    $members = MemberModel::whereHas('group', function ($query) use ($group) {
                        $query->where('dhcd_group_has_member.group_id', $group->group_id);
                        $query->where('dhcd_group_has_member.deleted_at', null);
                    })->get();
                }

                $list_members = [];
                if (count($members) > 0) {
                    foreach ($members as $member) {
                        $item = new \stdClass();
                        $item->id = $member->member_id;
                        $item->name = base64_encode($member->name);

                        $list_members[] = $item;
                    }
                }

                $data = '{
                    "data": {
                        "list_member_by_group": ' . json_encode($list_members) . '
                    },
                    "success" : true,
                    "message" : "ok!"
                }';
                $data = str_replace('null', '""', $data);

                //put cache
                $expiresAt = now()->addMinutes(3600);
                Cache::put($cache_data, $data, $expiresAt);
            }
            return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
        }
    }

    public function getMemberByCategory($request)
    {
        $members = [];
        $alias = $request->input('alias');
        Cache::forget('member_by_category_' . $alias);
        if (Cache::has('member_by_category_' . $alias)) {
            $members = Cache::get('member_by_category_' . $alias);
        } else {
            $category = DocumentCate::where('alias', $alias)->first();
            if (null != $category) {
                $members = MemberModel::whereHas('group', function ($query) use ($category) {
                        $query->where('dhcd_document_cate_has_member.document_cate_id', $category->document_cate_id);
                        $query->where('dhcd_document_cate_has_member.deleted_at', null);
                    })
                    ->get();
                $expiresAt = now()->addMinutes(3600);
                Cache::put('member_by_category_' . $alias, $members, $expiresAt);
            }
        }

        $list_members = [];
        if (count($members) > 0) {
            foreach ($members as $member) {
                $item = new \stdClass();
                $item->id = $member->member_id;
                $item->name = $member->name;

                $list_members[] = $item;
            }
        }

        $data = '{
                    "data": {
                        "list_member_by_document_cate": '. json_encode($list_members) .'
                    },
                    "success" : true,
                    "message" : "ok!"
                }';
        $data = str_replace('null', '""', $data);
        return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
    }
    
    public function postLogin($request){
        $data = [
            "success" => false,
            "message" => "Login thất bại",
        ];
        $validator = Validator::make($request->all(), [
            'u_name' => 'required|min:1|max:200',
            'password' => 'required'
        ], $this->messages);

        if (!$validator->fails()) {
            $u_name = $request->u_name;
            $password = $request->password;
            $ret = Auth::guard('member')->attempt(['u_name' => $u_name, 'password' => $password]);
            if (!empty($ret)) {
                $member = Auth::guard('member')->user();

                //get token
//                $tokenApi = app('Adtech\Api\App\Http\Controllers\Auth\LoginController')->login();
//                $token = json_decode($tokenApi->content())->access_token;

                $icon_link = ($member->avatar != '') ? config('site.url_storage') . $member->avatar : '';
                $data = [
                    "data" => [
                        "id"  => $member->member_id,
                        "avatar" => (self::is_url($member->avatar)) ? $member->avatar : $icon_link,
                        "u_name" => $member->u_name,
                        "is_files_main_customers" => true,
                        "email" => $member->email,
                        "ten_hien_thi" => $member->name,
                        "token" => [
                            "token" => ''
                        ]
                    ],
                    "success" => true,
                    "message" => "ok!"
                ];
            }
        }
        $data = str_replace('null', '""', $data);
        return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
    }

    public function getUserInfo($request){
        $data = [
            "success" => false,
            "message" => "Lỗi lấy thông tin",
        ];
        $member_id = $request->input("id");
        if (substr($member_id, 0, 5) == 'json_') {
            $member_str = base64_decode(substr($member_id, 5, strlen($member_id)));
            $member = explode('|', $member_str);
            $member_info = [
                "id" => $member[0],
                "anh_ca_nhan" => base64_encode(''),
                "ten_hien_thi" => base64_encode($member[1]),
                "email" => base64_encode(''),
                "so_dien_thoai" => base64_encode(''),
                "doan_thanh_nien" => base64_encode(''),
                "ngay_vao_dang" => base64_encode(''),
                "dan_toc" => base64_encode(''),
                "chuc_vu" => base64_encode($member[2]),
                "ton_giao" => base64_encode(''),
                "trinh_do_ly_luan" => base64_encode(''),
                "trinh_do_chuyen_mon" => base64_encode(''),
                "noi_lam_viec" => base64_encode('')
            ];
            $data = [
                "success" => true,
                "message" => "Lấy thông tin thành công",
                "data" => $member_info
            ];
        } else {
            //get cache
            $cache_data = 'data_api_userinfo_' . $member_id;
            if (Cache::has($cache_data)) {
                $data = Cache::get($cache_data);
            } else {

                $member = MemberModel::find($member_id);
                if (null != $member) {
                    $icon_link = ($member->avatar != '') ? config('site.url_storage') . $member->avatar : '';
                    $member_info = [
                        "id" => $member->member_id,
                        "anh_ca_nhan" => (self::is_url($member->avatar)) ? base64_encode($member->avatar) : base64_encode($icon_link),
                        "ten_hien_thi" => base64_encode($member->name),
                        "email" => base64_encode($member->email),
                        "so_dien_thoai" => base64_encode($member->phone),
                        "doan_thanh_nien" => base64_encode($member->don_vi),
                        "ngay_vao_dang" => base64_encode($member->ngay_vao_dang),
                        "dan_toc" => base64_encode($member->dan_toc),
                        "chuc_vu" => base64_encode($member->position_current),
                        "ton_giao" => base64_encode($member->ton_giao),
                        "trinh_do_ly_luan" => base64_encode($member->trinh_do_ly_luan),
                        "trinh_do_chuyen_mon" => base64_encode($member->trinh_do_chuyen_mon),
                        "noi_lam_viec" => base64_encode($member->address)
                    ];
                    $data = [
                        "success" => true,
                        "message" => "Lấy thông tin thành công",
                        "data" => $member_info
                    ];
                }
                $data = str_replace('null', '""', $data);

                //put cache
                $expiresAt = now()->addDays(5);
                Cache::put($cache_data, $data, $expiresAt);
            }
        }
        return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
    }

    public function putChangePass($request){
        $data = [
            "success" => false,
            "message" => "Lỗi đổi mật khẩu"
        ];
        $validator = Validator::make($request->all(), [
            'id' => 'required|min:0|numeric',
            'token' => 'required',
            'old_password' => 'required',
            'new_password' => 'required'
        ], $this->messages);
        if (!$validator->fails()) {
            $member_id = $request->id;
            $token = $request->token;
            $old_password = $request->old_password;
            $new_password = $request->new_password;
            $member = MemberModel::find($member_id);
            if(!empty($member)){
                $password = $member->password;
                if (Hash::check($old_password , $password) && $old_password != $new_password){
                    MemberModel::where('member_id',$member_id)->update(['password' => bcrypt($new_password)]);
                    $data = [
                        "success" => true,
                        "message" => "Đổi mật khẩu thành công"
                    ];
                }
            }
        }
        $data = str_replace('null', '""', $data);
        return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
    }

    public function getRegister($request){
        $x = 1;
        $limit = $request->limit;
        while($x <= $limit) {
            $data_insert[] = [
                'name' => 'member'.$x,
                'gender' => 'male',
                'u_name' => 'member'.$x,
                'phone' => $x,
                'email' => 'member'.$x.'@gmail.com',
                'password' => bcrypt('123456'),
                'token' => 'token'.$x
            ];
            $x++;
        }
        if(DB::table('dhcd_member')->insert($data_insert)){
            echo 'done';
        }
    }

    function cmp($a, $b)
    {
        return strcmp($a->name, $b->name);
    }
}