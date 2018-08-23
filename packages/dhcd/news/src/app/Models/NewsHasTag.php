<?php

namespace Dhcd\News\App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsHasTag extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dhcd_news_has_tag';

    protected $primaryKey = 'news_has_tag_id';

    protected $guarded = ['news_has_tag_id'];
}
