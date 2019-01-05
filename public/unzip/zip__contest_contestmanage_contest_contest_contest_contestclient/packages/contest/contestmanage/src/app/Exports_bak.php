<?php
namespace Contest\Contestmanage\App;

use Contest\Contestmanage\App\Models\ContestResult;
use Contest\Contestmanage\App\Models\ContestRound;
use Contest\Contestmanage\App\Models\ContestTopic;
use Contest\Contestmanage\App\Models\UserContestInfo;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Excel;

class Exports implements FromQuery, WithHeadings, ShouldAutoSize, WithMapping
{
    use Exportable;

    public function __construct($data, $module = 'candidate')
    {
        $this->data = $data;
        $this->module = $module;
    }

    public function query()
    {
        $data = $this->data;
        if ($this->module == 'candidate') {
            $cond = [];
            if (!empty($data['table_id'])) {
                $cond['table_id'] = (int)$data['table_id'];
            }
            if (!empty($data['city_id'])) {
                $cond['city_id'] = (int)$data['city_id'];
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
                return $query;
        }
        elseif ($this->module == 'result'){
            $cond = [];
            if (!empty($data['table_id'])) {
                $cond['table_id'] = (int)$data['table_id'];
            }
            if (!empty($data['city_id'])) {
                $cond['city_id'] = (int)$data['city_id'];
            }
            if (!empty($data['district_id'])) {
                $cond['district_id'] = (int)$data['district_id'];
            }
            if (!empty($data['school_id'])) {
                $cond['school_id'] = (int)$data['school_id'];
            }
            if (!empty($data['round_id'])) {
                $cond['round_id'] = (int)$data['round_id'];
            }
            if (!empty($data['topic_id'])) {
                $cond['topic_id'] = (int)$data['topic_id'];
            }
            $query = ContestResult::query()->where($cond);
            if(!empty($data['name'])){
                $query = $query->where('name','like','%'.$data['name'].'%');
            }
            return $query->orderBy('point_real','DESC');
        }

    }

    public function headings(): array
    {
        if ($this->module == 'candidate') {
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
        } elseif ($this->module == 'result') {
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
                'Lớp',
            ];
        }

    }

    public function map($invoice): array
    {
        if ($this->module == 'candidate') {
            return [
                $invoice->name,
                $invoice->u_name,
                $invoice->birthday,
                $invoice->gender =='male'?'Nam':'Nữ',
                $invoice->phone,
                $invoice->email,
                $invoice->city_name,
                $invoice->district_name,
                $invoice->school_name,
                $invoice->class_id,
            ];
        } elseif ($this->module == 'result') {
            $round = ContestRound::where('round_type','real')->pluck('display_name','round_id');
            $topic = ContestTopic::where('topic_type','real')->pluck('display_name','topic_id');
            return [
                $invoice->name,
                $invoice->u_name,
                $invoice->birthday,
                $round[$invoice->round_id],
                $topic[$invoice->topic_id],
                $invoice->repeat_time,
                $invoice->point_real,
                $this->convertTime($invoice->used_time),
                $invoice->gender =='male'?'Nam':'Nữ',
                $invoice->phone,
                $invoice->email,
                $invoice->city_name,
                $invoice->district_name,
                $invoice->school_name,
                $invoice->class_id,
            ];
        }

    }
    public function convertTime($time){
        $min = (int)($time/60000);
        $sec = (int)(($time - ($min*60000))/1000);
        $tik = substr($time,-3);
        return $min . "'" . $sec . '"'.$tik;
    }
}
?>