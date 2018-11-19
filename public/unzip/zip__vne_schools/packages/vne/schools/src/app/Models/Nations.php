<?php
/**
 * Created by PhpStorm.
 * User: CuongPT
 * Date: 11/14/2018
 * Time: 11:25 AM
 */

namespace Vne\Schools\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class Nations extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql_cuocthi';
    protected $table = 'vne_nations';
    protected $primaryKey = 'id';
    protected $fillable = ['nation'];
    protected $dates = ['delete_at'];
}