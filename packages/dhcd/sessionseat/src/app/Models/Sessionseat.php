<?php

namespace Dhcd\Sessionseat\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sessionseat extends Model {
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dhcd_sessionseat';

    protected $primaryKey = 'sessionseat_id';

    protected $fillable = ['sessionseat_name','sessionseat_img'];

    protected $dates = ['deleted_at'];
}
