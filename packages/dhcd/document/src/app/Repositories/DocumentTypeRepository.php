<?php

namespace Dhcd\Document\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\DB;
use Dhcd\Document\App\Models\DocumentType;
use Cache;
/**
 * Class DemoRepository
 * @package Dhcd\Document\Repositories
 */
class DocumentTypeRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Dhcd\Document\App\Models\DocumentType';
    }

    public function findAll() {

        $result = $this->model::query();
        return $result;
    }
    
    public static function getTypes(){
        $types = DocumentType::get()->toArray();
        return $types;
        if(Cache::has('document_type_list')){            
            $types = Cache::get('document_type_list');            
            return $types;            
        } else {
            $types = DocumentType::get()->toArray();
            $data = [];
            if($types){
                Cache::forever('document_type_list',$types);
                $data = $types;                
            }
            return $data;
        }        
    }
}
