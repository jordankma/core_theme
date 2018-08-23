<?php

namespace Dhcd\Member\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model {
	use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dhcd_group';

    protected $primaryKey = 'group_id';

    protected $guarded = ['group_id'];
    
    protected $fillable = ['name'];

    public function getMember(){
        return $this->belongsToMany('Dhcd\Member\App\Models\Member', 'dhcd_group_has_member', 'group_id', 'member_id');
    }
}