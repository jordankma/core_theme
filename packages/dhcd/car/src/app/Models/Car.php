<?php

namespace Dhcd\Car\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model {
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dhcd_car';

    protected $primaryKey = 'car_id';

    protected $fillable = ['doan_id', 'car_num', 'car_bs'];

    protected $dates = ['deleted_at'];
}
