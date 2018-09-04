<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Dhcd\Member\App\Elastic;

use Elasticquent\ElasticquentTrait;
use Dhcd\Member\App\Models\Member;
use Exception;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Description of MemberElastic
 *
 * @author tuanlv
 */
class MemberElastic extends ElasticEloquent
{
    protected $table = 'member';
    protected $primaryKey = 'member_id';
    protected $fillable = array('name');
    
    protected $mappingProperties = [
        'member_id' => ['type' => 'integer', 'store' => 'yes'],
        'token' => ['type' => 'string', 'store' => 'yes'],
        'name' => ['type' => 'string', 'analyzer' => 'standard'],
        'sort' => ['type' => 'string', 'store' => 'yes'],
        'email' => ['type' => 'string', 'store' => 'yes'],
        'phone' => ['type' => 'string', 'store' => 'yes'],
        'type' => ['type' => 'integer', 'store' => 'yes'],
        'bang_cap' => ['type' => 'string'],
        'ngay_vao_dang' => ['type' => 'string'],
        'ngay_vao_doan' => ['type' => 'string'],
        'dan_toc' => ['type' => 'string'],
        'position_id' => ['type' => 'integer', 'store' => 'yes'],
        'position_current' => ['type' => 'string'],
        'ton_giao' => ['type' => 'string'],
        'trinh_do_ly_luan' => ['type' => 'string'],
        'trinh_do_chuyen_mon' => ['type' => 'string'],
        'address' => ['type' => 'string', 'store' => 'yes'],
        'gender' => ['type' => 'string', 'store' => 'yes'],
        'avatar' => ['type' => 'string', 'store' => 'yes'],
        'don_vi' => ['type' => 'string', 'store' => 'yes'],
        'birthday' => ['type' => 'string', 'store' => 'yes'],
        'status' => ['type' => 'string', 'analyzer' => 'standard'],
        'remember_token' => ['type' => 'string'],
        'created_at' => ['type' => 'date', 'store' => 'yes', 'format' => 'yyyy-MM-dd HH:mm:ss'],
        'updated_at' => ['type' => 'date', 'store' => 'yes', 'format' => 'yyyy-MM-dd HH:mm:ss'],
        'deleted_at' => ['type' => 'date', 'store' => 'yes', 'format' => 'yyyy-MM-dd HH:mm:ss'],

        'group' => [
            'type' => 'nested',
            'properties' => [
                'group_id' => ['type' => 'integer', 'store' => 'yes'],
                'name' => ['type' => 'string'],
                'alias' => ['type' => 'string'],
                'desc' => ['type' => 'string', 'analyzer' => 'standard'],
                'image' => ['type' => 'string'],
                'type' => ['type' => 'integer', 'store' => 'yes'],
                'status' => ['type' => 'string', 'analyzer' => 'standard'],
                'created_at' => ['type' => 'date', 'store' => 'yes', 'format' => 'yyyy-MM-dd HH:mm:ss'],
                'updated_at' => ['type' => 'date', 'store' => 'yes', 'format' => 'yyyy-MM-dd HH:mm:ss'],
                'deleted_at' => ['type' => 'date', 'store' => 'yes', 'format' => 'yyyy-MM-dd HH:mm:ss'],
            ]
        ]
    ];
    
    public function __construct()
    {
    }
    
    /**
     * Add to Search Index
     *
     * @throws Exception
     * @return array
     */
    public  function addDocument($key, $data)
    {
//        if (!$this->exists) {
//            throw new Exception('Document does not exist.');
//        }
        
        $params = $this->getBasicEsParams();
        
        // Get our document body data.
        $params['body'] = $data;
        
        // The id for the document must always mirror the
        // key for this model, even if it is set to something
        // other than an auto-incrementing value. That way we
        // can do things like remove the document from
        // the index, or get the document from the index.
        $params['id'] = $key;
        
        return $this->getElasticSearchClient()->index($params);
    }
    
    public static function _builDocument($item)
    {
        $group = $item['group'];
        $dataGroups = [];
        if (!empty($group)) {
            foreach ($group as $g) {
                $dataGroups[] = [
                    'group_id' => $g['group_id'],
                    'name' => $g['name'],
                    'alias' => $g['alias'],
                    'desc' => $g['desc'],
                    'image' => $g['image'],
                    'type' => $g['type'],
                    'status' => $g['status'],
                    'created_at' => $g['created_at'],
                    'updated_at' => $g['updated_at'],
                    'deleted_at' => $g['deleted_at']
                ];
            }
        }
        $item['groups'] = $dataGroups;
        unset($item['group']);
        return $item;
    }
    
    public static function saveDocument($id)
    {
        if (!$id) return;
        $member_elactic = new MemberElastic();
        $item = Member::where('member_id',$id)->with('group')->first()->toArray();
        $data = self::_builDocument($item);
        $member_elactic->addDocument($item['member_id'], $data);
    }
    
    public static function syncDocuments($limit = 100)
    {
        $items = Member::where('sync_es', 'pending')->with('group')->get()->toArray();
        $member_elactic = new MemberElastic();
        if ($items) {
            foreach ($items as $item) {
                $data = self::_builDocument($item);
                $member_elactic->addDocument($item['member_id'], $data);
                
                Member::where('member_id', $item['member_id'])->update(['sync_es' => 'done']);
            }
        } else {
            die('DONE');
        }
    }
    
    public function customSearch($params)
    {
        $mustFilters = [];
        $mustNotFilters = [];
        $multiMatch = [];
        
        //Search bằng
        $this->setMultiMatch($params, $multiMatch, [
            [
                'query' => 'name',
                'fields' => [
                    'name',
                    'alias',
                ],
            ],
        ]);
        $this->setMustFilters($params, $mustFilters, [
            'member_id',
            'name',
            'type',
            'status'
        ]);
        // Search hoặc
        // $this->setMustFiltersNested($params, $mustFilters, [
        //     'group.name',
        // ]);
        // $this->setMustRange($params, $mustFilters, [
        //     'created_at',
        //     'updated_at',
        //     'price',
        //     'number_sale',
        //     'price_promo'
        // ]);

        $this->setMustNotFilters($params, $mustNotFilters, [
            'not_must',
        ]);
        $filter = empty($params) ? [] : [
            'bool' => [
                'must' => !empty($mustFilters[0]) ? $mustFilters : [],
                'must_not' => !empty($mustNotFilters[0]) ? $mustNotFilters : []
            ]
        ];
        $query = [
            'function_score' => [
                'query' => [
                    'filtered' => [
                        'query' => $multiMatch,
                        'filter' => $filter
                    ]
                ]
            ],
        
        ];
        
        if (!empty($params['is_random'])) {
            $query['function_score']['random_score'] = [
                'seed' => time()
            ];
        }
        
        $limit = !empty($params['limit']) ? $params['limit'] : null;
        $offset = !empty($params['offset']) ? $params['offset'] : 0;
        $sort = !empty($params['sort']) ? $params['sort'] : ['member_id' => 'desc'];
        $data = MemberElastic::searchByQuery($query, null, null, $limit, $offset, $sort);

        return $data;
    }
	public function remove(CourseElactic $course) {
        $course->removeFromIndex();
    }
}
