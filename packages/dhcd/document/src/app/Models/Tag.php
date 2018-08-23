<?php

namespace Dhcd\Document\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model {
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dhcd_tags';

    protected $primaryKey = 'tag_id';

    protected $fillable = ['name', 'alias'];

    protected $dates = ['deleted_at'];
    public $timestamps = true;
}
