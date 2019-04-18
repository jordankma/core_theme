<?php
namespace Contest\Contestmanage\App;

use Contest\Contestmanage\App\Models\ContestResult;
use Contest\Contestmanage\App\Models\UserContestInfo;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;

class Exports implements FromQuery, WithHeadings, ShouldAutoSize, WithMapping
{
    use Exportable;

    public function __construct($data, $module = 'candidate',$heading,$mapping)
    {
        $this->data = $data;
        $this->module = $module;
        $this->heading = $heading;
        $this->mapping = $mapping;
    }

    public function query()
    {
        $data = $this->data;
        $cond = [];
        if (!empty($data['class_id'])) {
            $cond['class_id'] = (int)$data['class_id'];
        }
        if (!empty($data['u_name'])) {
            $cond['u_name'] = $data['u_name'];
        }
        if (!empty($data['class_id'])) {
            $cond['class_id'] = (int)$data['class_id'];
        }
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
        if (!empty($data['round_id'])) {
            $cond['round_id'] = (int)$data['round_id'];
        }
        if (!empty($data['topic_id'])) {
            $cond['topic_id'] = (int)$data['topic_id'];
        }

        if ($this->module == 'candidate') {
            $query = UserContestInfo::query()->where($cond);
            if(!empty($data['name'])){
                $query = $query->where('name','like','%'.$data['name'].'%');
            }
            return $query;
        }
        elseif ($this->module == 'result'){

            $query = ContestResult::query()->where($cond);
            if(!empty($data['name'])){
                $query = $query->where('name','like','%'.$data['name'].'%');
            }
            return $query->orderBy('total_point','DESC')->orderBy('used_time',"ASC");
        }

    }

    public function headings(): array
    {
        return $this->heading;

    }

    public function map($invoice): array
    {
        $arr_map = [];
        if(!empty($this->mapping)){
            foreach ($this->mapping as $key => $value){
                $arr_map[] = $invoice->$value;
            }
        }
        return $arr_map;
    }
    public function convertTime($time){
        $min = (int)($time/60000);
        $sec = (int)(($time - ($min*60000))/1000);
        $tik = substr($time,-3);
        return $min . "'" . $sec . '"'.$tik;
    }
}
?>