<?php

namespace Contest\Contestmanage\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;

/**
 * Class DemoRepository
 * @package Exam\Exammanage\Repositories
 */
class ContestSettingRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Contest\Contestmanage\App\Models\ContestSetting';
    }

    public function findAll() {

        $result = $this->model::query();
        return $result;
    }
    public function getSettingData($param){
        $setting = $this->model::where('param', $param)->first();
        if(!empty($setting)){
            if($setting->data_type == 'array'){
                $arr = [];
                foreach ($setting->data as $key => $value){
                    $arr[$value['key']] = $value['value'];
                }
                return $arr;
            }
            else{
                return $setting->data;
            }

        }
        else{
            return null;
        }
    }
}
