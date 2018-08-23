<?php

namespace Dhcd\Document\App\Models;

use Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentType extends Model {
    use SoftDeletes;
    protected $_html;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dhcd_document_types';

    protected $primaryKey = 'document_type_id';

    protected $fillable = ['name','type','extentions'];
    
    protected $dates = ['deleted_at'];
    
    public $timestamps = true;
    
}
