<?php
namespace Contest\Contestmanage\App;


class ContestFunc
{
    public function convertExamTime($milisecond){
        if(!empty($milisecond)){
            $min = str_pad((int)($milisecond/60000),2, '0', STR_PAD_LEFT);
            $sec = str_pad((int)(($milisecond - ($min*60000))/1000),2, '0', STR_PAD_LEFT);
            $tik = str_pad($milisecond - ($min*60000 + $sec*1000),3, '0', STR_PAD_LEFT);
            return $min.':'.$sec.'.'.$tik;
        }

    }

}