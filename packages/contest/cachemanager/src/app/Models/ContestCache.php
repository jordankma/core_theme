<?php

namespace Contest\Cachemanager\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContestCache extends Model {
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'contest_cache';

    protected $primaryKey = 'cache_id';

    protected $fillable = ['cache_name','cache_key','cache_url','cache_tags'];

    protected $dates = ['deleted_at'];
}
