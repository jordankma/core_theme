<?php

namespace Dhcd\Seat\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seat extends Model {
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dhcd_seat';

    protected $primaryKey = 'seat_id';

    protected $fillable = ['seat', 'doan_id', 'sessionseat_id', 'seat_staff', 'note'];

    protected $dates = ['deleted_at'];

    public function sessionseat()
    {
        return $this->belongsTo(' Dhcd\Sessionseat\App\Models\Sessionseat', 'sessionseat_id', 'sessionseat_id');
    }
}
