<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Dhcd\Member\App\Elastic;

use Elasticquent\ElasticquentTrait;
use Dhcd\Member\App\Models\Member;
use Dhcd\Member\App\Models\Group;
use Exception;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Description of GroupElastic
 *
 * @author tuanlv
 */
class GroupElastic extends ElasticEloquent
{
    protected $table = 'group';
    protected $primaryKey = 'group_id';
    protected $fillable = array('name');
    
    protected $mappingProperties = [
        'member_id' => ['type' => 'integer', 'store' => 'yes'],
        'token' => ['type' => 'string', 'store' => 'yes'],
        'name' => ['type' => 'string', 'analyzer' => 'standard'],
        'alias' => ['type' => 'string', 'analyzer' => 'standard'],
        'desc' => ['type' => 'string', 'analyzer' => 'standard'],
        'image' => ['type' => 'string', 'analyzer' => 'standard'],
        'type' => ['type' => 'string', 'analyzer' => 'standard'],
        'status' => ['type' => 'string', 'analyzer' => 'standard'],
        'created_at' => ['type' => 'date', 'store' => 'yes', 'format' => 'yyyy-MM-dd HH:mm:ss'],
        'updated_at' => ['type' => 'date', 'store' => 'yes', 'format' => 'yyyy-MM-dd HH:mm:ss'],
        'deleted_at' => ['type' => 'date', 'store' => 'yes', 'format' => 'yyyy-MM-dd HH:mm:ss'],

        'members' => [
            'type' => 'nested',
            'properties' => [
                'member_id' => ['type' => 'integer', 'store' => 'yes'],
                'name' => ['type' => 'string'],
                'type' => ['type' => 'string', 'analyzer' => 'standard'],
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
        $members = $item['get_member'];
        $dataMembers = [];
        if (!empty($members)) {
            foreach ($members as $m) {
                $dataMembers[] = [
                    'member_id' => $m['member_id'],
                    'name' => $m['name'],
                    'type' => $m['type'],
                    'status' => $m['status'],
                    'created_at' => $m['created_at'],
                    'updated_at' => $m['updated_at'],
                    'deleted_at' => $m['deleted_at']
                ];
            }
        }
        $item['member'] = $dataMembers;
        unset($item['get_member']);
        return $item;
    }
    
    public static function saveDocument($id)
    {
        if (!$id) return;
        $group_elastic = new GroupElastic();
        $item = Group::where('group_id',$id)->with('getMember')->first()->toArray();
        $data = self::_builDocument($item);
        $group_elastic->addDocument($item['group_id'], $data);
    }
    
    public static function syncDocuments($limit = 100)
    {
        $items = Group::where('sync_es', 'pending')->with('getMember')->get()->toArray();
        $group_elastic = new GroupElastic();
        if ($items) {
            foreach ($items as $item) {
                $data = self::_builDocument($item);
                $group_elastic->addDocument($item['group_id'], $data);
                
                Group::where('group_id', $item['group_id'])->update(['sync_es' => 'done']);
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
            'group_id',
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
        $data = GroupElastic::searchByQuery($query, null, null, $limit, $offset, $sort);
        return $data;
    }
	public function remove(CourseElactic $course) {
        $course->removeFromIndex();
    }
}
