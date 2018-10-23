<?php

namespace Contest\Contestmanage\App;


class ContestEnvironment {

    private $type = [
        'season' => 'Mùa thi',
        'round' => 'Vòng thi',
        'topic' => 'Màn thi',
        'topic_round' => 'Màn thi - vòng'
    ];
    private $environment = [
        'all' => 'Tất cả',
        'cocos' => 'Cocos',
        'vue' => 'VueJs'
    ];
    private $option = [
        'default' => ' Mặc định',
        'special' => 'Đặc biệt'
    ];

    private $round_type = [
        'test' => 'Thi thử',
        'real' => 'Thi thật'
    ];

    public function getType(){
        return $this->type;
    }
    public function getEnvironment(){
        return $this->environment;
    }
    public function getOption(){
        return $this->option;
    }

    public function getRoundType(){
        return $this->round_type;
    }

}
