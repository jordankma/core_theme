<?php

namespace Dhcd\Document\App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentHasCate extends Model {
    //use SoftDeletes;
    protected $_html;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dhcd_document_has_cate';

    protected $primaryKey = 'document_has_cate_id';
    
    public $timestamps = false;
                
    
}
