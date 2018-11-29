<?php
/**
 * Created by PhpStorm.
 * User: sujian
 * Date: 14-8-30
 * Time: 上午10:26
 */

namespace Gdmin\Fields;

class TimeField extends DateTimeField{

    public function getDefault(){
        return $this->value === null ? time() : $this->value;
    }
    public function validate($name){
        $default_value = \Input::get($name."_default", time());
        $value = \Input::get($name, time());
        if(!is_numeric($value) and $default_value == $value){
            return 0;
        }

        return $this->formatValue($value, $default_value);
    }

    public function formatValue($value){
        if(is_numeric($value)){
            return intval($value);
        }
        else{
            return strtotime($value);
        }
    }
}