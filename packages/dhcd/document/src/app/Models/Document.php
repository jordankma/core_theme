<?php

namespace Dhcd\Document\App\Models;

use Cache;
use Illuminate\Database\Eloquent\Model;
use Dhcd\Document\App\Models\DocumentHasCate;
use Dhcd\Document\App\Models\DocumentType;
use Dhcd\Document\App\Models\DocumentCate;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model {
    use SoftDeletes;
    protected $_html;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dhcd_documents';

    protected $primaryKey = 'document_id';

    protected $fillable = ['name','file','status','descript','document_type_id','avatar','alias','is_offical','is_reserve','icon'];
    
    protected $dates = ['deleted_at'];
    
    public $timestamps = true;
    
            
    public function getType(){
        return $this->belongsTo(DocumentType::class,'document_type_id');
    }
    
    public function getDocumentCate(){
        return $this->belongsToMany(DocumentCate::class, 'dhcd_document_has_cate','document_id','document_cate_id');
    }
    public function getTags(){
        return $this->belongsToMany(Tag::class, 'dhcd_tags_item','document_id', 'tag_id');
    }
        
}
