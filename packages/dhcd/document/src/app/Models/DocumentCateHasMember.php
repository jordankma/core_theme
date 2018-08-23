<?php

namespace Dhcd\Document\App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentCateHasMember extends Model {
    //use SoftDeletes;
    protected $_html;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dhcd_document_cate_has_member';

    protected $primaryKey = 'document_cate_has_member_id';
    
    public $timestamps = false;
                
    
}
