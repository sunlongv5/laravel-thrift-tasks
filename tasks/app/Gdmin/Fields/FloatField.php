<?php
/**
 * Created by PhpStorm.
 * User: sujian
 * Date: 14-8-30
 * Time: 上午10:00
 */

namespace Gdmin\Fields;

class FloatField extends BaseField{
    public function __construct($value=null, $verbose_name=null, $choices=null, $widget=null){
        parent::__construct($value === null ? 0.0 : $value, $verbose_name, $choices, $widget);
    }

    public function getDefault(){
        return $this->value === null ? 0.0 : $this->value;
    }

    public function validate($name){
        $value = \Input::get($name, 0.0);
        return $this->formatValue($value);
    }

    public function formatValue($value){
        if($value === null){
            return $this->getDefault();
        }
        return floatval($value);
    }
}
