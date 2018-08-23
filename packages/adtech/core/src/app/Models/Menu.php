<?php

namespace Adtech\Core\App\Models;

use Illuminate\Database\Eloquent\Model;
use \Adtech\Application\Cms\Libraries\Acl as AdtechAcl;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $connection = 'mysql_core';

    protected $table = 'adtech_core_menus';

    protected $primaryKey = 'menu_id';

    protected $fillable = ['type', 'parent', 'name', 'route_name', 'domain_id', 'group'];

    protected $dates = ['deleted_at'];

    public function domains()
    {
        return $this->hasMany('Adtech\Core\App\Models\Domain');
    }
}
