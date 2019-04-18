<?php

namespace Contest\Contestmanage\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\DB;

/**
 * Class DemoRepository
 * @package Exam\Exammanage\Repositories
 */
class ContestRoundRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Contest\Contestmanage\App\Models\ContestRound';
    }

    public function findAll() {

        $result = $this->model::query();
        return $result;
    }

    public function findCurrentRound($time,$type){
        $result = $this->model::where('round_type',$type)->whereRaw('UNIX_TIMESTAMP(`start_date`) < ?',[$time])->whereRaw('UNIX_TIMESTAMP(`end_date`) > ?',[$time])->first();
        return $result;
    }

    public function getRoundType($round_id){
        $result = $this->model::find($round_id);
        if($result){
            return $result->round_type;
        }
    }

    public function getListPluck(){
        $result = $this->model::where('round_type', 'real')->get();
        $res = [];
        if(!empty($result)){
            foreach($result as $key => $value){
                $res[$value->round_id] = base64_decode($value->display_name);
            }
        }
        return $res;

    }
}
