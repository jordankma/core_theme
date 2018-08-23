<?php

namespace Dhcd\Document\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\DB;
use Dhcd\Document\App\Models\DocumentCate;
use Cache;
/**
 * Class DemoRepository
 * @package Dhcd\Document\Repositories
 */
class DocumentCateRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Dhcd\Document\App\Models\DocumentCate';
    }

    public function findAll() {

        $result = $this->model::query();
        return $result;
    }
    
    public function getCates(){
        
        if(Cache::has('document_cates_list')){            
            $cates = Cache::get('document_cates_list');            
            return $cates;            
        } else {
            $cates = DocumentCate::select('document_cate_id','name','alias','parent_id','icon')->orderBy('sort','desc')->orderBy('parent_id','desc')->get()->toArray();
            $data = [];
            if($cates){
                Cache::forever('document_cates_list',$cates);
                $data = $cates;                
            }
            return $data;
        }        
    }
    
}
