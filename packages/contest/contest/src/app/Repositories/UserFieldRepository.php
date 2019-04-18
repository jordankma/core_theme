<?php

namespace Contest\Contest\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\DB;

/**
 * Class DemoRepository
 * @package Contest\Contest\Repositories
 */
class UserFieldRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Contest\Contest\App\Models\UserField';
    }

    public function findAll() {

        $result = $this->model::query();
        return $result;
    }

}
