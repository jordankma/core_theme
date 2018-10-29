<?php

namespace Vne\Member\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class Member extends Model {
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'vne_member';

    protected $primaryKey = 'id';

    protected $fillable = ['name'];

    protected $dates = ['deleted_at'];

    public function addColumn($sTable, $sColumn) {
        $isColExist = Schema::connection("mysql_cuocthi")->hasColumn($sTable,$sColumn);
        if($isColExist == false){
            Schema::connection('mysql_cuocthi')->table($sTable, function(Blueprint $table) use ($sColumn, &$fluent){
                $fluent = $table->string($sColumn)->nullable();
            });
            return response()->json($fluent);   
        }
    }
}
