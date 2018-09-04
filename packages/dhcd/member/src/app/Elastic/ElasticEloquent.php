<?php

namespace Dhcd\Member\App\Elastic;
use Elasticquent\ElasticquentTrait;
use Exception;
use Illuminate\Database\Eloquent\Model as Eloquent;


class ElasticEloquent extends Eloquent
{
    use ElasticquentTrait;
    
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
    
    /**
     * Add to Search Index
     *
     * @throws Exception
     * @return array
     */
    public function addDocument($key, $data)
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
    
    /**
     * Build mảng filters theo điều kiện Must(AND) cho elasticsearch
     * @param $params mảng dữ liệu cần filter|search
     * @param $mustFilters mảng filters
     * @param $attributes những attribute cần filter
     */
    protected function setMustFilters($params, & $mustFilters, $attributes){
        $dataMustTerm = null;
        foreach($attributes as $attr){
            if(!empty($params[$attr])){
                $values = is_array($params[$attr]) ? $params[$attr] : [$params[$attr]];
                foreach ($values as $value){
                    $mustFilters[] = [
                        "term" => [$attr => $value]
                    ];
                }
                
            }
        }
    }
    
    protected function setMultiMatch($params, & $multiMatch, $attributes){
        foreach($attributes as $attr){
            if(!empty($params[$attr['query']])){
                $fields = !empty($attr['fields']) ? $attr['fields'] : [$attr['query']];
                $multiMatch[] = ['multi_match' => [
                    'query' => $params[$attr['query']],
                    'fields' => $fields,
                ]];
            }
        }
    }
    
    protected function setMustNotFilters($params, & $mustNotFilters, $attributes){
        $dataMustNotTerm = [];
        if(!empty($params['not_must'])){
            foreach ($params['not_must'] as $key => $item){
                $values = is_array($item) ? $item : [$item];
                foreach ($values as $value){
                    $dataMustNotTerm[] = [
                        "term" => [$key => $value]
                    ];
                }
            }
        }
        $mustNotFilters = $dataMustNotTerm;
    }
    
    
    
    protected function setMustFiltersNested($params, & $mustFilters, $attributes){
        $dataMustTerm = [];
        foreach($attributes as $attr){
            if(!empty($params[$attr])){
                
                $values = is_array($params[$attr]) ? $params[$attr] : [$params[$attr]];
                $path = current(explode('.', $attr));
                
                foreach ($values as $value){
                    $dataMustTerm[] = [
                        "term" => [$attr => $value]
                    ];
                }
                $mustFilters[] = [
                    "nested" => [
                        "path" => $path,
                        "filter" => [
                            "bool" => [
                                "should" => $dataMustTerm
                            ]
                        ]
                    ]
                ];
            }
        }
    }
    
    protected function setMustRange($params, & $mustFilters, $attributes){
        $dataMustRange = [];
        foreach($attributes as $attr){
            if(!empty($params[$attr])){
                $values = is_array($params[$attr]) ? $params[$attr] : [$params[$attr]];
                $mustFilters[] = [
                    "range" => [$attr => $values]
                ];
            }
        }
    }
    
}