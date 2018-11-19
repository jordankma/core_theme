<?php

namespace Vne\Schools\App\Models;

use Illuminate\Support\Facades\DB;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use MongoDB\Operation\FindOneAndUpdate;


class District extends Eloquent {
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $connection = 'mongodb';
    protected $primaryKey = '_id';
    public function nextid(){
//        $cursor = DB::connection('mongodb')->command(array('eval' => 'getNextId("districtid")'));
//        $data = $cursor->toArray();
//        $this->_id = (int)$data[0]->retval;
        $this->_id = self::getID();
    }
    private static function getID()
    {
        $seq = DB::connection('mongodb')->getCollection('counters')->findOneAndUpdate(
            ['_id' => 'districtid'],
//            ['model' => $collection],
            ['$inc' => ['seq' => 1]],
            ['new' => true, 'upsert' => true, 'returnDocument' => FindOneAndUpdate::RETURN_DOCUMENT_AFTER]
        );
        return $seq->seq;
    }

    public static function bootUseAutoIncrementID()
    {
        static::creating(function ($model) {
            $model->sequencial_id = self::getID($model->getTable());
        });
    }
    /**
     * Get the casts array.
     *
     * @return array
     */
    public function getCasts()
    {
        return $this->casts;
    }
    protected $collection = 'district';
    protected $fillable = ['district', 'alias'];
    protected $dates = ['deleted_at'];
    public function province(){
        return $this->belongsTo('Vne\Province\App\Models\Province','province_id','_id');
    }
    public function ward(){
        return $this->hasMany('Vne\Wards\App\Models\Ward','district_id','_id');
    }
}
