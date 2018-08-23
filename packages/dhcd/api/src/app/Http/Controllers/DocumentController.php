<?php

namespace Dhcd\Api\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Dhcd\Document\App\Models\DocumentCate;
use Validator;
use Cache;
use Crypt;

class DocumentController extends BaseController
{
    public function listDocCate()
    {
        $listCate = app('Dhcd\Document\App\Http\Controllers\DocumentCateController')->getListCategory();
        return $listCate;
    }
}