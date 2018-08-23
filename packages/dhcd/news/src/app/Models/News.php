<?php

namespace Dhcd\News\App\Models;

use Illuminate\Database\Eloquent\Model;
use Dhcd\News\App\Models\NewsCat;
use Illuminate\Database\Eloquent\SoftDeletes;
class News extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dhcd_news';

    protected $primaryKey = 'news_id';
    protected static $cat;
    protected $guarded = ['news_id'];
    protected $dates = ['deleted_at'];
    
    
    public function getCats() {
        return $this->belongsToMany('Dhcd\News\App\Models\NewsCat', 'dhcd_news_has_cat', 'news_id', 'news_cat_id');
    }

    public function getTags() {
        return $this->belongsToMany('Dhcd\News\App\Models\NewsTag', 'dhcd_news_has_tag', 'news_id', 'news_tag_id');
    }
}
