<?php

namespace Dhcd\Topic\App\Models;

use Illuminate\Database\Eloquent\Model;
use Dhcd\Member\App\Models\Member;
use Illuminate\Database\Eloquent\SoftDeletes;
class Topic extends Model {
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $dates = ['deleted_at'];
    protected $table = 'dhcd_topic';

    protected $primaryKey = 'topic_id';

    protected $guarded = ['topic_id'];
    protected $fillable = ['name'];

    public function getMember(){
    	return $this->belongsToMany('Dhcd\Member\App\Models\Member', 'dhcd_topic_has_member', 'topic_id', 'member_id');
    }
}