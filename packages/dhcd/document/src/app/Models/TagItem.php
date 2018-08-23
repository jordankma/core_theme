<?php

namespace Dhcd\Document\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TagItem extends Model {
    //use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dhcd_tags_item';

    protected $primaryKey = 'id';

    protected $fillable = ['tag_id', 'document_cate_id', 'document_id'];
   
    public $timestamps = false;
}
