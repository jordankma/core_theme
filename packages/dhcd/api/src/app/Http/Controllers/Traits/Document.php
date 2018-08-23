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
        $pdf_base64 = "files/1.pdf";
        $content = $this->my_simple_crypt( $pdf_base64, 'f' );
    }

    public function getMenuDocument()
    {
        Cache::forget('api_document_cate');
        if (Cache::has('api_document_cate')) {
            $menus = Cache::get('api_document_cate');
        } else {
            $menus = app('Dhcd\Document\App\Http\Controllers\DocumentCateController')->getListCategory();
            $expiresAt = now()->addMinutes(3600);
            Cache::put('api_document_cate', $menus, $expiresAt);
        }

        $list_menus = [];
        if (count($menus) > 0) {
            foreach ($menus as $menu) {
                $menu = (object) $menu;
                $item = new \stdClass();
                $item->id = $menu->document_cate_id;
                $item->title = $menu->name;
                $item->alias = $menu->alias;
                $item->type = 1;
                $item->type_api = 1;
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
        return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
    }

    public function getAllDocument()
    {
        Cache::forget('api_all_document_cate');
        if (Cache::has('api_all_document_cate')) {
            $documentCates = Cache::get('api_all_document_cate');
        } else {
            $documentCates = app('Dhcd\Document\App\Http\Controllers\DocumentCateController')->getAllCategory();
            $expiresAt = now()->addMinutes(3600);
            Cache::put('api_all_document_cate', $documentCates, $expiresAt);
        }

        $page = 1;
        $list_menus = [];
        if (count($documentCates) > 0) {
            foreach ($documentCates as $cate) {

                $cate = (object) $cate;
                $list_docs = [];
                $alias = $cate->alias;
                Cache::forget('api_doc_document_page_' . $alias . '_' . $page);
                if (Cache::has('api_doc_document_page_' . $alias . '_' . $page)) {
                    $filesDoc = Cache::get('api_doc_document_page_' . $alias . '_' . $page);
                } else {
                    $filesDoc = DocModel::with('getDocumentCate')
                        ->whereHas('getDocumentCate', function ($query) use ($cate) {
                            $query->where('dhcd_document_has_cate.document_cate_id', $cate->document_cate_id);
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
                                $listFile[] = $files;
                            }

                            $item->id = $file->document_id;
                            $item->title = base64_encode($file->name);
                            $item->alias = base64_encode($file->alias);
                            $item->sub_title = base64_encode($file->descript);
                            $item->icon = (self::is_url($file->icon)) ? $file->icon : config('app.url') . '' . $file->icon;
                            $item->files = $listFile;
                            $item->is_offical = $file->is_offical;
                            $item->is_reserve = $file->is_reserve;
                            $item->type_file = '';
                            $item->date_created = date_format($file->created_at, 'Y-m-d');
                            $item->date_modified = date_format($file->updated_at, 'Y-m-d');

                            $list_docs[] = $item;
                        }
                        //
                    }
                    $total_page = $filesDoc->lastPage();
                }

                $item = (object) $cate;
                $item = new \stdClass();
                $item->id = $cate->document_cate_id;
                $item->title = $cate->name;
                $item->alias = $cate->alias;
                $item->list_document = $list_docs;
                $item->type = 1;
                $item->type_api = 1;
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
        return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
    }

    public function getFilesDocument($request) {
        $page = $request->input('page', 1);
        $alias = $request->input('alias', '');
        $list_news = $filesDoc = [];
        $total_page = 0;

        $documentCate = DocumentCate::where('alias', $alias)->first();
        if (null != $documentCate) {
            $cateChildren = DocumentCate::where('parent_id', $documentCate->document_cate_id)->get();

            if (count($cateChildren) > 0) {

                $list_menus = [];
                if (count($cateChildren) > 0) {
                    foreach ($cateChildren as $child) {
                        $item = new \stdClass();
                        $item->id = $child->document_cate_id;
                        $item->title = $child->name;
                        $item->alias = $child->alias;
                        $item->descript = $child->descript;
                        $item->type = 1;
                        $item->type_api = 1;
                        $item->icon = config('site.url_storage') . $child->icon;
                        $list_menus[] = $item;
                    }
                }

                $data = '{
                    "data": {
                        "list_document": '. json_encode($list_menus) .'
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
                                $listFile[] = $files;
                            }

                            $item->id = $file->document_id;
                            $item->title = base64_encode($file->name);
                            $item->alias = base64_encode($file->alias);
                            $item->sub_title = base64_encode($file->descript);
                            $item->icon = (self::is_url($file->icon)) ? $file->icon : config('app.url') . '' . $file->icon;
                            $item->files = $listFile;
                            $item->is_offical = $file->is_offical;
                            $item->is_reserve = $file->is_reserve;
                            $item->type_file = '';
                            $item->date_created = date_format($file->created_at, 'Y-m-d');
                            $item->date_modified = date_format($file->updated_at, 'Y-m-d');

                            $list_news[] = $item;
                        }
                        //
                    }
                    $total_page = $filesDoc->lastPage();
                }

                $data = '{
                    "data": {
                        "list_document": '. json_encode($list_news) .',
                        "total_page": ' . $total_page . ',
                        "current_page": '. $page .'
                    },
                    "success" : true,
                    "message" : "ok!"
                }';

                return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
            }
        }
    }

    public function getFilesDetail($request) {
        $alias = $request->input('alias', '');
        Cache::forget('api_doc_document_detail_' . $alias);
        if (Cache::has('api_doc_document_detail_' . $alias)) {
            $filesDoc = Cache::get('api_doc_document_detail_' . $alias);
        } else {
            $filesDoc = DocModel::where('alias', $alias)->first();
            $expiresAt = now()->addMinutes(3600);
            Cache::put('api_doc_document_detail_' . $alias, $filesDoc, $expiresAt);
        }

        $item = new \stdClass();
        if (null != $filesDoc) {
            
                $listFiles = json_decode($filesDoc->file, true);
                if (count($listFiles) > 0) {
                    $listFile = [];
                    foreach ($listFiles as $files) {
                        $files['name'] = (self::is_url($files['name'])) ? $files['name'] : config('app.url') . '' . $files['name'];
                        $listFile[] = $files;
                    }

                    $item->id = $filesDoc->document_id;
                    $item->title = base64_encode($filesDoc->name);
                    $item->alias = base64_encode($filesDoc->alias);
                    $item->sub_title = base64_encode($filesDoc->descript);
                    $item->icon = (self::is_url($filesDoc->avatar)) ? $filesDoc->avatar : config('app.url') . '' . $filesDoc->avatar;
                    $item->files = $listFile;
                    $item->type_file = '';
                    $item->date_created = date_format($filesDoc->created_at, 'Y-m-d');
                    $item->date_modified = date_format($filesDoc->updated_at, 'Y-m-d');
                }
                //
        }

        $data = '{
                    "data": '. json_encode($item) .',
                    "success" : true,
                    "message" : "ok!"
                }';
        return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
    }
}