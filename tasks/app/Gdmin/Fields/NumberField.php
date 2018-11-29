<?php
/**
 * Created by PhpStorm.
 * User: sujian
 * Date: 14-8-30
 * Time: 上午9:59
 */

namespace Gdmin\Fields;

class NumberField extends BaseField{
    public function __construct($value=null, $verbose_name=null, $choices=null, $widget=null){
        parent::__construct($value === null ? 0 : $value, $verbose_name, $choices, $widget);
    }

    public function getDefault(){
        return $this->value === null ? 0 : $this->value;
    }

    public function validate($name){
        $value = \Input::get($name, null);
        return $this->formatValue($value);
    }

    public function formatValue($value){
        if($value === null){
            return $this->getDefault();
        }
        return intval($value);
    }
}
