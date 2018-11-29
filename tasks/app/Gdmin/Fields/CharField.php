<?php
/**
 * Created by PhpStorm.
 * User: sujian
 * Date: 14-8-29
 * Time: 下午12:54
 */

namespace Gdmin\Fields;

class CharField extends BaseField{
    public function __construct($value=null, $verbose_name=null, $choices=null, $widget=null){
        parent::__construct($value === null ? '' : $value, $verbose_name, $choices, $widget);
    }

    public function getDefault(){
        return $this->value === null ? '' : $this->value;
    }
}