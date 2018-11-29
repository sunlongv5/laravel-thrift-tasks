<?php
/**
 * Created by PhpStorm.
 * User: sujian
 * Date: 14-8-30
 * Time: 上午9:59
 */

namespace Gdmin\Fields;

class BoolField extends BaseField{
    public function __construct($value=null, $verbose_name=null, $choices=null, $widget=null){
        parent::__construct($value === null ? true : $value, $verbose_name, $choices, $widget);
    }

    public function getDefault(){
        return $this->value === null ? true : $this->value;
    }

    public function validate($name){
        $value = \Input::get($name, null);
        return $this->formatValue($value);
    }

    public function formatValue($value){
        if($value === null){
            return $this->getDefault();
        }
        if($value == '0'){
            return false;
        }
        return empty($value) ? false : true;
    }

    public function to_html($value=null){
        return empty($value) ? '0' : '1';
    }
}
