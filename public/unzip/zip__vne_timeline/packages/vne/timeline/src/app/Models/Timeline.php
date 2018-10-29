<?php

namespace Vne\Timeline\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Timeline extends Model {
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $connection = 'mysql_contest';

    protected $table = 'vne_timeline';

    protected $primaryKey = 'id';

    protected $fillable = ['titles','starttime','endtime','note'];

    protected $dates = ['deleted_at'];
}
