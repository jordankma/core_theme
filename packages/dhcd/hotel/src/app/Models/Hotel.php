<?php

namespace Dhcd\Hotel\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hotel extends Model {
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dhcd_hotel';

    protected $primaryKey = 'hotel_id';

    protected $fillable = ['hotel', 'doan_id', 'address', 'img', 'hotel_staff', 'note'];

    protected $dates = ['deleted_at'];
}
