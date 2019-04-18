<?php

namespace Contest\Contestclient\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\DB;

/**
 * Class DemoRepository
 * @package Contest\Contestclient\Repositories
 */
class DemoRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Contest\Contestclient\App\Models\Demo';
    }

    public function findAll() {

        $result = $this->model::query();
        return $result;
    }
}
