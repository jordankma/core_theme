<?php

namespace Vne\Companionunit\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comgroup extends Model {
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    // protected $connection = 'mysql_cuocthi';

    protected $table = 'vne_comgroup';

    protected $primaryKey = 'id';

    protected $fillable = ['comgroup'];

    protected $dates = ['deleted_at'];
}
