<?php
/**
 * Created by PhpStorm.
 * User: sujian
 * Date: 14-8-30
 * Time: 下午2:42
 */

namespace Gdmin\Fields;

class ListField extends BaseField{
    public function __construct($value=null, $verbose_name=null, $choices=null, $widget=null, $default=null){
        parent::__construct($value === null ? new CharField() : $value, $verbose_name, $choices, $widget == null ? 'gdmin::widget.list' : $widget);

        $this->default = $default;
    }

    public function getDefault(){
        return $this->default === null ? $this->value->getDefault() : $this->default;
    }

    public function validate($name){
        $value = \Input::get($name, []);
        if(!is_array($value)){
            return [$this->value->formatValue($value)];
        }
        return $this->formatValue($value);
    }

    public function formatValue($value){
        if(empty($value)){
            return $this->getDefault();
        }

        $values = [];
        foreach($value as $v){
            $values[] = $this->value->formatValue($v);
        }
        return $values;
    }
}
