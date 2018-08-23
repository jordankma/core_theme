<?php

namespace Dhcd\Administration\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ProvineCity extends Model {
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dhcd_provine_city';
    protected $dates = ['deleted_at'];
    protected $primaryKey = 'provine_city_id';

    protected $guarded = ['provine_city_id'];
    protected $fillable = ['name'];
}