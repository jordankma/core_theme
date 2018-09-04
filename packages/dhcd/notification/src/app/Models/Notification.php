<?php

namespace Dhcd\Notification\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model {
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dhcd_notification';

    protected $primaryKey = 'notification_id';

    protected $fillable = ['name'];

    protected $dates = ['deleted_at'];


}
