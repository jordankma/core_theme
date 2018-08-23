<?php

namespace Dhcd\Topic\App\Models;

use Illuminate\Database\Eloquent\Model;

class TopicHasMember extends Model {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dhcd_topic_has_member';

    protected $primaryKey = 'topic_has_member_id';

    protected $guarded = ['topic_has_member_id'];
    protected $fillable = ['name'];
}