<?php

namespace Vne\Mail\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gmail extends Model {
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'g_mail';

    protected $primaryKey = 'g_mail_id';

    protected $fillable = ['title'];

    protected $dates = ['deleted_at'];
}
