<?php

namespace Dhcd\Member\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\DB;

/**
 * Class DemoRepository
 * @package Dhcd\Member\Repositories
 */
class MemberRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Dhcd\Member\App\Models\Member';
    }

    public function deleteID($id) {
        return $this->model->where('member_id', '=', $id)->update(['visible' => 0]);
    }

    public function findAll() {

        DB::statement(DB::raw('set @rownum=0'));
        $result = $this->model::query()->with('getPosition');
        $result->select('dhcd_member.*', DB::raw('@rownum  := @rownum  + 1 AS rownum'));

        return $result;
    }
}
