<?php

namespace Contest\Contestmanage\App\Models;

use Elasticquent\ElasticquentTrait;

class UserContestInfo_Es extends Eloquent {
    use ElasticquentTrait;
    protected $table = 'users_exam_info';
//    protected $connection = 'elastic';
    protected $fillable = ['member_id','name','u_name','token','phone_user','gender','birthday','province_id','province_name',
        'district_id','district_name','school_name','school_id','target','target_name','class_id','class_name','facebook',
        'account_holder','account_number','bank_name','bank_agency','account_phone','indenty_number','account_phone','address','email','phone','season'];
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
        'reason' => array(
            'type' => 'integer',
        ),
    );
}
