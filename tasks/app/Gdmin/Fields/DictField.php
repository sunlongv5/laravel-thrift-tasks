<?php
/**
 * Created by PhpStorm.
 * User: sujian
 * Date: 14-8-30
 * Time: 下午2:42
 */

namespace Gdmin\Fields;

class DictField extends BaseField{
    public function __construct($value=null, $verbose_name=null, $choices=null, $widget=null){
        parent::__construct($value === null ? [] : $value, $verbose_name, $choices, $widget);

        $this->widget = 'gdmin::widget.dict';

    }

    public function getDefault(){
        $data = [];
        foreach($this->value as $key=>$field){
            $data[$key] = $field->getDefault();
        }
        return empty($data) ? new \stdClass() : $data;
    }

    public function validate($name){
        $data = [];
        foreach($this->value as $key=>$field){
            $data[$key] = $field->validate($name.'_'.$key);
        }

        if(empty($value)){
            $value = new \stdClass();
        }
        return $value;
    }

    public function to_html($value=null){
        if(is_array($value)){
            $str_value = '';
            foreach($value as $k => $v){
                $str_value = $str_value.','.$k.":".$this->to_html($v);
            }
            return $str_value;
        }
        else if(is_object($value)){
            return '';
        }
        return strval($value);
    }
}
