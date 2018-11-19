<?php
namespace  Vne\Schools\App\Http\Traits;

use DB;
use MongoDB\Operation\FindOneAndUpdate;

trait SchoolsAutoIncrementID {
    /**
     * Increment the counter and get the next sequence
     *
     * @param $collection
     * @return mixed
     */
    private static function getID($collection)
    {
        $seq = DB::getCollection('counters')->findOneAndUpdate(
            ['model' => $collection],
            ['$inc' => ['seq' => 1]],
            ['new' => true, 'upsert' => true, 'returnDocument' => FindOneAndUpdate::RETURN_DOCUMENT_AFTER]
        );
        return $seq->seq;
    }
    /**
     * Boot the AutoIncrementID trait for the model.
     *
     * @return void
     */
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
}