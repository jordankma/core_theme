<?php

namespace Dhcd\Api\App\Http\Controllers\Traits;

use Dhcd\Document\App\Models\Document as DocModel;
use Dhcd\Document\App\Models\DocumentCate;
use Validator;
use Cache;

trait Document
{

    public function getTest()
    {
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', 'http://localhost:8080/split?path=/src/public/files/test/chap01.pdf');

        $pdf_base64 = "files/test/test.pdf";
        $content = $this->my_simple_crypt( $pdf_base64, 'f' );
    }

    public function getMenuDocument()
    {
        $cache_name = 'api_document_cate';
        Cache::forget($cache_name);
        if (Cache::has($cache_name)) {
            $menus = Cache::get($cache_name);
        } else {
            $menus = app('Dhcd\Document\App\Http\Controllers\DocumentCateController')->getListCategory();
            $expiresAt = now()->addMinutes(3600);
            Cache::put($cache_name, $menus, $expiresAt);
        }

        $list_menus = [];
        if (count($menus) > 0) {
            foreach ($menus as $menu) {
                $menu = (object) $menu;
                $item = new \stdClass();
                $item->id = $menu->document_cate_id;
                $item->title = base64_encode($menu->name);
                $item->alias = base64_encode($menu->alias);
                $item->type = base64_encode(1);
                $item->type_api = base64_encode(1);
                $item->icon = config('site.url_storage') . $menu->icon;
                $list_menus[] = $item;
            }
        }

        $data = '{
                    "data": {
                        "list_info_item_menu": '. json_encode($list_menus) .'
                    },
                    "success" : true,
                    "message" : "ok!"
                }';
        $data = str_replace('null', '""', $data);
        return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
    }

    public function getAllDocument()
    {
        $cache_name = 'api_all_document_cate';
        Cache::forget($cache_name);
        if (Cache::has($cache_name)) {
            $documentCates = Cache::get($cache_name);
        } else {
            $documentCates = app('Dhcd\Document\App\Http\Controllers\DocumentCateController')->getAllCategory();
            $expiresAt = now()->addMinutes(3600);
            Cache::put($cache_name, $documentCates, $expiresAt);
        }

        $list_menus = [];
        if (count($documentCates) > 0) {
            foreach ($documentCates as $cate) {

                $cate = (object) $cate;
                $list_docs = [];
                $alias = $cate->alias;

                $cache_name = 'api_doc_document_page_' . $alias . '_all';
                Cache::forget($cache_name);
                if (Cache::has($cache_name)) {
                    $filesDoc = Cache::get($cache_name);
                } else {
                    $filesDoc = DocModel::with('getDocumentCate')
                        ->whereHas('getDocumentCate', function ($query) use ($cate) {
                            $query->where('dhcd_document_has_cate.document_cate_id', $cate->document_cate_id);
                        })->get();

                    $expiresAt = now()->addMinutes(3600);
                    Cache::put($cache_name, $filesDoc, $expiresAt);
                }

                if (count($filesDoc) > 0) {
                    foreach ($filesDoc as $file) {
                        $item = new \stdClass();
                        $listFiles = json_decode($file->file, true);
                        if (count($listFiles) > 0) {
                            $listFile = [];
                            foreach ($listFiles as $files) {
                                $files['name'] = (self::is_url($files['name'])) ? $files['name'] : config('app.url') . '' . $files['name'];
                                $files['name'] = base64_encode($files['name']);
                                $listFile[] = $files;
                            }

                            $item->id = $file->document_id;
                            $item->title = base64_encode($file->name);
                            $item->alias = base64_encode($file->alias);
                            $item->sub_title = base64_encode($file->descript);
                            $item->icon = (self::is_url($file->icon)) ? $file->icon : config('app.url') . '' . $file->icon;
                            $item->files = $listFile;
                            $item->is_offical = base64_encode($file->is_offical);
                            $item->is_reserve = base64_encode($file->is_reserve);
                            $item->updated_file_at = strtotime($file->updated_file_at) * 1000;
                            $item->type_file = '';
                            $item->type_view = base64_encode('detail');
                            $item->date_created = strtotime($file->created_at) * 1000;
                            $item->date_modified = strtotime($file->updated_at) * 1000;

                            $list_docs[] = $item;
                        }
                        //
                    }
                }

                $item = new \stdClass();
                $item->id = $cate->document_cate_id;
                $item->title = base64_encode($cate->name);
                $item->alias = base64_encode($cate->alias);
                $item->list_document = $list_docs;
                $item->type = base64_encode(1);
                $item->type_api = base64_encode(1);
                $item->icon = config('site.url_storage') . $cate->icon;
                $list_menus[] = $item;
            }
        }

        $data = '{
                    "data": {
                        "list_document_cates": '. json_encode($list_menus) .'
                    },
                    "success" : true,
                    "message" : "ok!"
                }';
        $data = str_replace('null', '""', $data);
        return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
    }

    public function getFilesDocument($request) {
        $page = $request->input('page', 1);
        $alias = $request->input('alias', '');
        $list_document = [];
        $total_page = 0;

        $documentCate = DocumentCate::where('alias', $alias)->first();
        if (null != $documentCate) {
            //cat child
            $cateChildren = DocumentCate::where('parent_id', $documentCate->document_cate_id)->get();

            //doc child
            $cache_name = 'api_doc_document_page_' . $alias . '_all';
            Cache::forget($cache_name);
            if (Cache::has($cache_name)) {
                $filesDoc = Cache::get($cache_name);
            } else {
                $filesDoc = DocModel::with('getDocumentCate')
                    ->whereHas('getDocumentCate', function ($query) use ($documentCate) {
                        $query->where('dhcd_document_has_cate.document_cate_id', $documentCate->document_cate_id);
                    })->get();

                $expiresAt = now()->addMinutes(3600);
                Cache::put($cache_name, $filesDoc, $expiresAt);
            }

            if (count($cateChildren) > 0 && count($filesDoc) > 0) {

                if (count($cateChildren) > 0) {
                    foreach ($cateChildren as $child) {
                        $item = new \stdClass();
                        $item->id = $child->document_cate_id;
                        $item->title = base64_encode($child->name);
                        $item->alias = base64_encode($child->alias);
                        $item->descript = base64_encode($child->descript);
                        $item->type = base64_encode(1);
                        $item->type_api = base64_encode(1);
                        $item->type_view = base64_encode('category');
                        $item->icon = config('site.url_storage') . $child->icon;
                        $list_document[] = $item;
                    }
                }

                if (count($filesDoc) > 0) {
                    foreach ($filesDoc as $file) {
                        $item = new \stdClass();
                        $listFiles = json_decode($file->file, true);
                        if (count($listFiles) > 0) {
                            $listFile = [];
                            foreach ($listFiles as $files) {
                                $files['name'] = (self::is_url($files['name'])) ? $files['name'] : config('app.url') . '' . $files['name'];
                                $files['name'] = base64_encode($files['name']);
                                $listFile[] = $files;
                            }

                            $item->id = $file->document_id;
                            $item->title = base64_encode($file->name);
                            $item->alias = base64_encode($file->alias);
                            $item->sub_title = base64_encode($file->descript);
                            $item->icon = (self::is_url($file->icon)) ? $file->icon : config('app.url') . '' . $file->icon;
                            $item->files = $listFile;
                            $item->is_offical = base64_encode($file->is_offical);
                            $item->is_reserve = base64_encode($file->is_reserve);
                            $item->updated_file_at = strtotime($file->updated_file_at) * 1000;
                            $item->type_file = '';
                            $item->type_view = base64_encode('detail');
                            $item->date_created = strtotime($file->created_at) * 1000;
                            $item->date_modified = strtotime($file->updated_at) * 1000;

                            $list_document[] = $item;
                        }
                        //
                    }
                }

                $data = '{
                    "data": {
                        "list_document": '. json_encode($list_document) .',
                        "total_page": 1,
                        "current_page": 1
                    },
                    "success" : true,
                    "message" : "ok!"
                }';
                return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
            } elseif (count($cateChildren) > 0) {

                if (count($cateChildren) > 0) {
                    foreach ($cateChildren as $child) {
                        $item = new \stdClass();
                        $item->id = $child->document_cate_id;
                        $item->title = base64_encode($child->name);
                        $item->alias = base64_encode($child->alias);
                        $item->descript = base64_encode($child->descript);
                        $item->type = base64_encode(1);
                        $item->type_api = base64_encode(1);
                        $item->type_view = base64_encode('category');
                        $item->icon = base64_encode(config('site.url_storage') . $child->icon);
                        $list_document[] = $item;
                    }
                }

                $data = '{
                    "type": "category",
                    "data": {
                        "list_document": '. json_encode($list_document) .'
                    },
                    "success" : true,
                    "message" : "ok!"
                }';
                return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');

            } else {
                Cache::forget('api_doc_document_page_' . $alias . '_' . $page);
                if (Cache::has('api_doc_document_page_' . $alias . '_' . $page)) {
                    $filesDoc = Cache::get('api_doc_document_page_' . $alias . '_' . $page);
                } else {
                    $filesDoc = DocModel::with('getDocumentCate')
                        ->whereHas('getDocumentCate', function ($query) use ($documentCate) {
                            $query->where('dhcd_document_has_cate.document_cate_id', $documentCate->document_cate_id);
                        })->paginate(10);

                    $expiresAt = now()->addMinutes(3600);
                    Cache::put('api_doc_document_page_' . $alias . '_' . $page, $filesDoc, $expiresAt);
                }

                if (count($filesDoc) > 0) {
                    foreach ($filesDoc as $file) {
                        $item = new \stdClass();
                        $listFiles = json_decode($file->file, true);
                        if (count($listFiles) > 0) {
                            $listFile = [];
                            foreach ($listFiles as $files) {
                                $files['name'] = (self::is_url($files['name'])) ? $files['name'] : config('app.url') . '' . $files['name'];
                                $files['name'] = base64_encode($files['name']);
                                $listFile[] = $files;
                            }

                            $item->id = $file->document_id;
                            $item->title = base64_encode($file->name);
                            $item->alias = base64_encode($file->alias);
                            $item->sub_title = base64_encode($file->descript);
                            $item->icon = (self::is_url($file->icon)) ? base64_encode($file->icon) : base64_encode(config('app.url') . '' . $file->icon);
                            $item->files = $listFile;
                            $item->is_offical = base64_encode($file->is_offical);
                            $item->is_reserve = base64_encode($file->is_reserve);
                            $item->updated_file_at = base64_encode($file->updated_file_at);
                            $item->type_file = '';
                            $item->type_view = base64_encode('detail');
                            $item->date_created = base64_encode(strtotime($file->created_at) * 1000);
                            $item->date_modified = base64_encode(strtotime($file->updated_at) * 1000);

                            $list_document[] = $item;
                        }
                        //
                    }
                    $total_page = $filesDoc->lastPage();
                }

                $data = '{
                    "type": "detail",
                    "data": {
                        "list_document": '. json_encode($list_document) .',
                        "total_page": ' . $total_page . ',
                        "current_page": '. $page .'
                    },
                    "success" : true,
                    "message" : "ok!"
                }';
                $data = str_replace('null', '""', $data);
                return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
            }
        }
    }

    public function getFilesDetail($request) {
        $alias = $request->input('alias', '');

        $cache_name = 'api_doc_document_detail_' . $alias;
        Cache::forget($cache_name);
        if (Cache::has($cache_name)) {
            $filesDoc = Cache::get($cache_name);
        } else {
            $filesDoc = DocModel::where('alias', $alias)->first();
            $expiresAt = now()->addMinutes(3600);
            Cache::put($cache_name, $filesDoc, $expiresAt);
        }

        $item = new \stdClass();
        if (null != $filesDoc) {
            
                $listFiles = json_decode($filesDoc->file, true);
                if (count($listFiles) > 0) {
                    $listFile = [];
                    foreach ($listFiles as $files) {
                        $files['name'] = (self::is_url($files['name'])) ? $files['name'] : config('app.url') . '' . $files['name'];
                        $files['name'] = base64_encode($files['name']);
                        $listFile[] = $files;
                    }

                    $item->id = $filesDoc->document_id;
                    $item->title = base64_encode($filesDoc->name);
                    $item->alias = base64_encode($filesDoc->alias);
                    $item->sub_title = base64_encode($filesDoc->descript);
                    $item->icon = (self::is_url($filesDoc->avatar)) ? $filesDoc->avatar : config('app.url') . '' . $filesDoc->avatar;
                    $item->files = $listFile;
                    $item->type_file = '';
                    $item->date_created = strtotime($filesDoc->created_at) * 1000;
                    $item->date_modified = strtotime($filesDoc->updated_at) * 1000;
                }
                //
        }

        $data = '{
                    "data": '. json_encode($item) .',
                    "success" : true,
                    "message" : "ok!"
                }';
        $data = str_replace('null', '""', $data);
        return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
    }
}