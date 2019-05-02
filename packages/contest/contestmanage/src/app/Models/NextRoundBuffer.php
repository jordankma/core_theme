<?php

namespace Contest\Contestmanage\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NextRoundBuffer extends Model {
    use SoftDeletes;
    protected $connection = 'mysql_cuocthi';
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'contest_buffers';

    protected $primaryKey = 'id';

    protected $fillable = ['member_id','round_id','topic_id','name','u_name','total_point','used_time','repeat_time','birthday',
        'email','phone','phone_user','province_id','province_name','district_id','district_name','school_id',
        'school_name','target'];

    protected $dates = ['deleted_at'];
}
