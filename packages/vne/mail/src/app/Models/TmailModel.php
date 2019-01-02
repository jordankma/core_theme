<?php

namespace Vne\Mail\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tmail extends Model {
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 't_mail';

    protected $primaryKey = 't_mail_id';

    protected $fillable = ['title'];

    protected $dates = ['deleted_at'];
}
