<?php

namespace Dhcd\News\App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsHasCat extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dhcd_news_has_cat';

    protected $primaryKey = 'news_has_cat_id';

    protected $guarded = ['id'];
}
