<?php

namespace Contest\Contestmanage\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\DB;

/**
 * Class DemoRepository
 * @package Exam\Exammanage\Repositories
 */
class FormLoadRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Contest\Contestmanage\App\Models\FormLoad';
    }

    public function findAll() {

        $result = $this->model::query();
        return $result;
    }

    public function getFilterField($env,$alias){
        $res = [];
        if(!empty($env) && !empty($alias)) {
            $result = $this->model::where('env', $env)->where('alias', $alias)->first();
            if (!empty($result->general)) {
                foreach ($result->general as $key => $value) {
                    if (!empty($value) && $value['is_search'] == 1) {
                        if ($value['is_search'] == 1) {
                            $res[] = $value;

                        }
                    }
                }
            }
        }
        return $res;
    }

    public function getResultField($env,$alias){
        $res = [];
        if(!empty($env) && !empty($alias)){
            $result = $this->model::where('env',$env)->where('alias',$alias)->first();
            if(!empty($result->general)){
                foreach ($result->general as $key => $value){
                    if (!empty($value) && $value['show_on_result'] == 1) {
                        if ($value['show_on_result'] == 1) {
                            $res[] = $value;

                        }
                    }
                }
            }
        }
        return $res;
    }
}
