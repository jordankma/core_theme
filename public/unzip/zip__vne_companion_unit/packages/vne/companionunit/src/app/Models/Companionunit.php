<?php

namespace Vne\Companionunit\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Companionunit extends Model {
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $connection = 'mysql_contest';

    protected $table = 'vne_comunit';

    protected $primaryKey = 'id';

    protected $fillable = ['comname','comlink','comnote','image'];

    protected $dates = ['deleted_at'];
}
