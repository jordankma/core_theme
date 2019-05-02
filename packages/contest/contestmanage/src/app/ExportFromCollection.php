<?php
namespace Contest\Contestmanage\App;

use Contest\Contestmanage\App\Models\ContestResult;
use Contest\Contestmanage\App\Models\ContestRound;
use Contest\Contestmanage\App\Models\ContestTopic;
use Contest\Contestmanage\App\Models\NextRoundBuffer;
use Contest\Contestmanage\App\Models\UserContestInfo;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Excel;

class ExportFromCollection implements  FromCollection, WithHeadings, ShouldAutoSize, WithMapping
{
    use Exportable;

    public function __construct($data, $module = 'candidate',$heading = null, $mapping = null)
    {
        $this->data = $data;
        $this->module = $module;
        $this->heading = $heading;
        $this->mapping = $mapping;
    }

    public function collection()
    {
        $data = $this->data;
        $limit = !empty($data['limit'])?(int)$data['limit']:10;
        $page = !empty($data['page'])?(int)$data['page']:1;
        $skip = ($limit*($page - 1));

        if ($this->module == 'candidate') {
            $cond = [];
            if (!empty($data['table_id'])) {
                $cond['table_id'] = (int)$data['table_id'];
            }
            if (!empty($data['province_id'])) {
                $cond['province_id'] = (int)$data['province_id'];
            }
            if (!empty($data['district_id'])) {
                $cond['district_id'] = (int)$data['district_id'];
            }
            if (!empty($data['school_id'])) {
                $cond['school_id'] = (int)$data['school_id'];
            }
            $query = UserContestInfo::query()->where($cond);
            if(!empty($data['name'])){
                $query = $query->where('name','like','%'.$data['name'].'%');
            }
            return $query->skip($skip)->take($limit)->get();
        }
        if ($this->module == 'result'){
        $member_cond = [];
            $result_cond = [];
            $name = null;

    //        $cond['finish_exam'] = true;
            if (!empty($data['province_id']) && $data['province_id'] != 0) {
                $member_cond['province_id'] = (int)$data['province_id'];
            }
            if (!empty($data['district_id']) && $data['district_id'] != 0) {
                $member_cond['district_id'] = (int)$data['district_id'];
            }
            if (!empty($data['school_id']) && $data['school_id'] != 0) {
                $member_cond['school_id'] = (int)$data['school_id'];
            }
            if (!empty($data['table_id']) && $data['table_id']!= 0) {
                $member_cond['table_id'] = (int)$data['table_id'];
            }
            if (!empty($data['round_id']) && $data['round_id'] != 0) {
                $result_cond['round_id'] = (int)$data['round_id'];
            }
            if (!empty($data['topic_id']) && $data['topic_id'] != 0) {
                $result_cond['topic_id'] = (int)$data['topic_id'];
            }
            if (!empty($data['u_name'])) {
                $member_cond['u_name'] = $data['u_name'];
            }
            if (!empty($data['name'])){
                $name = $data['name'];
            }
            $result = ContestResult::with('candidate')->whereHas('candidate', function ($query) use($member_cond, $name){
                $query->where($member_cond);
                if(!empty($name)){
                    $query->where('name','like','%'.$name.'%');
                }
            })->where($result_cond)->orderBy('total_point', 'desc')->orderBy('used_time', 'asc')->skip($skip)->take($limit)->get();
    //            return $query->orderBy('point_real','DESC');
            return $result;
        }
        if($this->module == 'next_round'){
            DB::connection('mysql_cuocthi')->disableQueryLog();
            $result = NextRoundBuffer::where('province_id',(int)$data['province_id'])->orderBy('school_id','ASC')->orderBy('total_point','DESC')->orderBy('used_time',"ASC")->get();
            return $result;
        }
    }

    public function headings(): array
    {
        if(!empty($this->heading)){
            return $this->heading;
        }
        else {
            $data = $this->data;
            if ($this->module == 'candidate') {
                if ((int)$data['table_id'] == 1) {
                    return [
                        'Họ tên',
                        'Tài khoản',
                        'Ngày sinh',
                        'Giới tính',
                        'Điện thoại',
                        'Email',
                        'Tỉnh/ TP',
                        'Quận/ huyện',
                        'Trường',
                        'Lớp',
                    ];
                } else {
                    return [
                        'Họ tên',
                        'Tài khoản',
                        'Ngày sinh',
                        'Giới tính',
                        'Điện thoại',
                        'Email',
                        'Tỉnh/ TP',
                        'Quận/ huyện',
                        'Đơn vị'
                    ];
                }
            } elseif ($this->module == 'result') {

                if ((int)$data['table_id'] == 1) {
                    return [
                        'Họ tên',
                        'Tài khoản',
                        'Ngày sinh',
                        'Vòng thi',
                        'Tuần thi',
                        'Lần thi',
                        'Điểm',
                        'Thời gian',
                        'Giới tính',
                        'Điện thoại',
                        'Email',
                        'Tỉnh/ TP',
                        'Quận/ huyện',
                        'Trường',
                        'Lớp'
                    ];
                } else {
                    return [
                        'Họ tên',
                        'Tài khoản',
                        'Ngày sinh',
                        'Vòng thi',
                        'Tuần thi',
                        'Lần thi',
                        'Điểm',
                        'Thời gian',
                        'Giới tính',
                        'Điện thoại',
                        'Email',
                        'Tỉnh/ TP',
                        'Quận/ huyện',
                        'Đơn vị'
                    ];
                }

            }
        }

    }

    public function map($invoice): array
    {
        $arr_map = [];
        if(!empty($this->mapping)){
            foreach ($this->mapping as $key => $value){
                $arr_map[] = ($value == 'used_time') ? self::convertTime($invoice->$value) : $invoice->$value;
            }
            return $arr_map;
        }
       else {
           $data = $this->data;
           if ($this->module == 'candidate') {
               if ((int)$data['table_id'] == 1) {
                   return [
                       $invoice->name,
                       $invoice->u_name,
                       $invoice->birthday,
                       $invoice->gender == 'male' ? 'Nam' : 'Nữ',
                       $invoice->phone,
                       $invoice->email,
                       $invoice->city_name,
                       $invoice->district_name,
                       $invoice->school_name,
                       $invoice->class_id,
                   ];
               } else {
                   return [
                       $invoice->name,
                       $invoice->u_name,
                       $invoice->birthday,
                       $invoice->gender == 'male' ? 'Nam' : 'Nữ',
                       $invoice->phone,
                       $invoice->email,
                       $invoice->city_name,
                       $invoice->district_name,
                       $invoice->don_vi,
                   ];
               }
           } elseif ($this->module == 'result') {
               $round = ContestRound::where('round_type', 'real')->pluck('display_name', 'round_id');
               $topic = ContestTopic::where('topic_type', 'real')->pluck('display_name', 'topic_id');

               return [
                   $invoice->candidate->name,
                   $invoice->candidate->u_name,
                   $invoice->candidate->birthday,
                   $round[$invoice->round_id],
                   $topic[$invoice->topic_id],
                   $invoice->repeat_time,
                   $invoice->total_point,
                   $this->convertTime($invoice->used_time),
                   $invoice->candidate->gender == 'male' ? 'Nam' : 'Nữ',
                   $invoice->candidate->phone,
                   $invoice->candidate->email,
                   $invoice->candidate->province_name,
                   $invoice->candidate->district_name,
                   $invoice->candidate->school_name,
                   $invoice->candidate->class_id,
               ];
           }
       }

    }
    public function convertTime($time){
        $min = (int)($time/60000);
        $sec = (int)(($time - ($min*60000))/1000);
        $tik = substr($time,-3);
        return $min . ":" . $sec . '.'.$tik;
    }
}
?>