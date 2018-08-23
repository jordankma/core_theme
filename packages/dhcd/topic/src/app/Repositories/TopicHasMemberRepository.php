<?php

namespace Dhcd\Topic\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;

/**
 * Class DemoRepository
 * @package Dhcd\Topic\Repositories
 */
class TopicHasMemberRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Dhcd\Topic\App\Models\TopicHasMember';
    }

    public function deleteID($id) {
        return $this->model->where('topic_has_member_id', '=', $id)->update(['visible' => 0]);
    }
}
