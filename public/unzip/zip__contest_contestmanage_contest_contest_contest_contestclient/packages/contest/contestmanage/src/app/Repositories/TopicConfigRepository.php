<?php

namespace Contest\Contestmanage\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\DB;

/**
 * Class DemoRepository
 * @package Exam\Exammanage\Repositories
 */
class TopicConfigRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Contest\Contestmanage\App\Models\TopicConfig';
    }

    public function findAll() {

        $result = $this->model::query();
        return $result;
    }

    public function findByTopic($topic){
        $result = $this->model::query()->where('topic_id', $topic)->get();
        return $result;
    }
}
