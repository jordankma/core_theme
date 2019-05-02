<?php

namespace Contest\Contestmanage\App\Models;

use Elasticquent\ElasticquentTrait;
use Elasticsearch\ClientBuilder;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class ContestResult extends Eloquent {
    use ElasticquentTrait;
//    protected $connection = 'mongodb1';
//    protected $collection = 'user_data';
    public function __construct()
    {
        config(['elasticquent.default_index' => 'gthd_contest_exam_result']);
    }

    protected $connection = 'mongodb';
    protected $collection = 'contest_exam_result';
    protected $hidden = ['_id', 'updated_at', 'deleted_at'];
    const UPDATED_AT = null;
    public $timestamps = false;
    protected $mappingProperties = array(
        'member_id' => array(
            'type' => 'integer',
        ),
        'name' => array(
            'type' => 'text',
        ),
        'u_name' => array(
            'type' => 'text',
        ),
        'token' => array(
            'type' => 'text',
        ),
        'phone_user' => array(
            'type' => 'text',
        ),
        'gender' => array(
            'type' => 'text',
        ),
        'birthday' => array(
            'type' => 'text',
        ),
        'province_id' => array(
            'type' => 'integer',
        ),
        'province_name' => array(
            'type' => 'text',
        ),
        'district_id' => array(
            'type' => 'integer',
        ),
        'district_name' => array(
            'type' => 'text',
        ),
        'school_id' => array(
            'type' => 'integer',
        ),
        'school_name' => array(
            'type' => 'text',
        ),
        'target' => array(
            'type' => 'text',
        ),
        'target_name' => array(
            'type' => 'text',
        ),
        'class_id' => array(
            'type' => 'integer',
        ),
        'class_name' => array(
            'type' => 'text',
        ),
        'facebook' => array(
            'type' => 'text',
        ),
        'account_holder' => array(
            'type' => 'text',
        ),
        'account_number' => array(
            'type' => 'text',
        ),
        'bank_name' => array(
            'type' => 'text',
        ),
        'bank_agency' => array(
            'type' => 'text',
        ),
        'account_phone' => array(
            'type' => 'text',
        ),
        'indenty_number' => array(
            'type' => 'text',
        ),
        'address' => array(
            'type' => 'text',
        ),
        'accept_rule' => array(
            'type' => 'text',
        ),
        'email' => array(
            'type' => 'text',
        ),
        'phone' => array(
            'type' => 'text',
        ),
        'season' => array(
            'type' => 'integer',
        ),
        'total_point' => array(
            'type' => 'integer',
        ),
        'used_time' => array(
            'type' => 'integer',
        ),
        'repeat_time' => array(
            'type' => 'integer',
        ),
        'round_id' => array(
            'type' => 'integer',
        ),
        'topic_id' => array(
            'type' => 'integer'
        )
    );
    protected $indexSettings = [
        'analysis' => [
            'char_filter' => [
                'replace' => [
                    'type' => 'mapping',
                    'mappings' => [
                        '&=> and '
                    ],
                ],
            ],
            'filter' => [
                'word_delimiter' => [
                    'type' => 'word_delimiter',
                    'split_on_numerics' => false,
                    'split_on_case_change' => true,
                    'generate_word_parts' => true,
                    'generate_number_parts' => true,
                    'catenate_all' => true,
                    'preserve_original' => true,
                    'catenate_numbers' => true,
                ]
            ],
            'analyzer' => [
                'default' => [
                    'type' => 'custom',
                    'char_filter' => [
                        'html_strip',
                        'replace',
                    ],
                    'tokenizer' => 'whitespace',
                    'filter' => [
                        'lowercase',
                        'word_delimiter',
                    ],
                ],
            ],
        ],
    ];
//    protected $table = 'gthd_contest_exam_result';

//    protected $collection = 'user_data';
    public function nextId(){
        $current_id = Counters::find('contest_result_id');
        if(!empty($current_id)){
            $_id = $current_id->seq;
            $_id = $_id + 1;
            $current_id->seq = $_id;
            $current_id->update();
            $this->_id = $_id;
        }
    }

    public function setUpdatedAt($value)
    {
        // Do nothing.
    }

    public function getUpdatedAtColumn()
    {
        //Do-nothing
    }

    public static function createIndex($shards = null, $replicas = null)
    {
        $params = [
            'index' => 'gthd_contest_exam_result',
            'body' => [
                'mappings' => [
                    "contest_exam_result" => [
                        '_source' => [
                            'enabled' => true
                        ],
                        'properties' => array(
                            'member_id' => array(
                                'type' => 'integer',
                            ),
                            'name' => array(
                                'type' => 'text',
                            ),
                            'u_name' => array(
                                'type' => 'text',
                            ),
                            'token' => array(
                                'type' => 'text',
                            ),
                            'phone_user' => array(
                                'type' => 'text',
                            ),
                            'gender' => array(
                                'type' => 'text',
                            ),
                            'birthday' => array(
                                'type' => 'text',
                            ),
                            'province_id' => array(
                                'type' => 'integer',
                            ),
                            'province_name' => array(
                                'type' => 'text',
                            ),
                            'district_id' => array(
                                'type' => 'integer',
                            ),
                            'district_name' => array(
                                'type' => 'text',
                            ),
                            'school_id' => array(
                                'type' => 'integer',
                            ),
                            'school_name' => array(
                                'type' => 'text',
                            ),
                            'target' => array(
                                'type' => 'text',
                            ),
                            'target_name' => array(
                                'type' => 'text',
                            ),
                            'class_id' => array(
                                'type' => 'integer',
                            ),
                            'class_name' => array(
                                'type' => 'text',
                            ),
                            'facebook' => array(
                                'type' => 'text',
                            ),
                            'account_holder' => array(
                                'type' => 'text',
                            ),
                            'account_number' => array(
                                'type' => 'text',
                            ),
                            'bank_name' => array(
                                'type' => 'text',
                            ),
                            'bank_agency' => array(
                                'type' => 'text',
                            ),
                            'account_phone' => array(
                                'type' => 'text',
                            ),
                            'indenty_number' => array(
                                'type' => 'text',
                            ),
                            'address' => array(
                                'type' => 'text',
                            ),
                            'accept_rule' => array(
                                'type' => 'text',
                            ),
                            'email' => array(
                                'type' => 'text',
                            ),
                            'phone' => array(
                                'type' => 'text',
                            ),
                            'season' => array(
                                'type' => 'integer',
                            ),
                            'total_point' => array(
                                'type' => 'integer',
                            ),
                            'used_time' => array(
                                'type' => 'integer',
                            ),
                            'repeat_time' => array(
                                'type' => 'integer',
                            ),
                            'round_id' => array(
                                'type' => 'integer',
                            ),
                            'topic_id' => array(
                                'type' => 'integer'
                            ))
                    ]
                ]
            ]
        ];
        $client = ClientBuilder::fromConfig(config('elasticquent.config'));

        return $client->indices()->create($params);
//        return $client;
    }

    public static function customSearch($param,$offset = null,$limit = null){

        $query = [
            'body' => [
                'query' => [
                    'bool' => [
                        'must' => []
                    ]
                ]
            ]
        ];
        if(!empty($param)) {
            foreach ($param as $key => $value) {
                if($key != 'name'){
                    $query['body']['query']['bool']['must'][] = [
                        'match' => [
                            $key => $value
                        ]
                    ];
                }
            }
        }
        if(!empty($param['name'])){
            $query['body']['query']['wildcard'] = [
                'name' => '*'. $param['name'] .'*'
            ];
        }

        if(!empty($limit)){
            if(!empty($offset)){
                $query['body']['size'] = $limit;
                $query['body']['from'] = $offset;
            }
        }


//        echo '<pre>';print_r($query);echo '</pre>';die;
        return self::complexSearch($query);
    }

    public static function paginateSearch($params, $page, $limit){
        $query = [];
        $query['index'] = "gthd_contest_exam_result";
        if(!empty($params)) {
            $query['body']['query']['bool']['must'] = [];
            foreach ($params as $key => $value) {
                $query['body']['query']['bool']['must'][] = [
                    'match' => [
                        $key => $value
                    ]
                ];
            }

        }
        else{
            $query['body']['query']['match_all'] = [
                'boost' => 1.0
            ];
        }
        if(!empty($page) && !empty($limit)){
            $query['body']['from'] = ($page -1)*$limit;
            $query['body']['size'] = $limit;
        }
        return self::complexSearch($query)->paginate($limit);
    }
}
