<?php

namespace Vne\Mail\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\DB;

/**
 * Class DemoRepository
 * @package Vne\Mail\Repositories
 */
class TmailRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Vne\Mail\App\Models\Tmail';
    }

    public function findAll() {

        $result = $this->model::query();
        return $result;
    }
}
