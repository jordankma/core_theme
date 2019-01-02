<?php

namespace Vne\Newsrldv\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;

/**
 * Class DemoRepository
 * @package Vne\Newsrldv\Repositories
 */
class NewsHasCatRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Vne\Newsrldv\App\Models\NewsHasCat';
    }
}