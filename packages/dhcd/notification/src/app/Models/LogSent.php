<?php

namespace Dhcd\Notification\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LogSent extends Model {
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dhcd_log_sent';

    protected $primaryKey = 'log_sent_id';

    protected $fillable = ['group_id'];

    protected $dates = ['deleted_at'];

    public function group(){
        return $this->hasOne('Dhcd\Member\App\Models\Group', 'group_id');
    }

    public function notification(){
        return $this->hasOne('Dhcd\Notification\App\Models\Notification', 'notification_id', 'notification_id');
    }

    
}
