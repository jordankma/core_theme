<?php

namespace Contest\Contestmanage\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SeasonConfig extends Model {
    use SoftDeletes;
    protected $connection = 'mysql_cuocthi';
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'season_config';

    protected $primaryKey = 'season_config_id';

    protected $dates = ['deleted_at'];

    public function getConfig(){
//        return $this->hasMany('Contest\Contestmanage\App\Models\ContestConfig');
        return $this->hasOne(ContestConfig::class, 'config_id','config_id');
    }
}
