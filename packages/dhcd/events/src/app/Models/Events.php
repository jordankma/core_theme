<?php

namespace Dhcd\Events\App\Models;

use Illuminate\Database\Eloquent\Model;
use Dhcd\Events\App\Models\Event;
use Illuminate\Database\Eloquent\SoftDeletes;

class Events extends Model {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    use SoftDeletes;
   
    protected $table = 'dhcd_events';

    protected $primaryKey = 'event_id';

    protected $guarded = ['event_id'];

    protected $fillable = ['name', 'date'];

    protected $dates = ['deleted_at'];
    
}