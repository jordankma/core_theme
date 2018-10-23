<?php

namespace Contest\Contestmanage\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContestTopic extends Model {
    use SoftDeletes;
    protected $connection = 'mysql_cuocthi';
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'contest_topic';

    protected $primaryKey = 'topic_id';

    protected $fillable = ['topic_name'];

    protected $dates = ['deleted_at'];

    public function round(){
        return $this->belongsTo(ContestRound::class,'round_id','round_id');
    }

    public function getConfig(){
        return $this->hasOne(ContestConfig::class,'config_id','config_id');
    }
}
