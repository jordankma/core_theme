<?php

namespace Dhcd\Document\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\DB;

/**
 * Class DemoRepository
 * @package Dhcd\Document\Repositories
 */
class TagRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Dhcd\Document\App\Models\Tag';
    }
   
}
