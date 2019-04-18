<?php

namespace Contest\Cachemanager\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\DB;

/**
 * Class DemoRepository
 * @package Contest\Cachemanager\Repositories
 */
class ContestCacheRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Contest\Cachemanager\App\Models\ContestCache';
    }

    public function findAll() {

        $result = $this->model::query();
        return $result;
    }
}
