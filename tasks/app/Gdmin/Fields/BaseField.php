<?php


/**
 * Created by PhpStorm.
 * User: sujian
 * Date: 14-8-29
 * Time: 下午12:55
 */

namespace Gdmin\Fields;

class BaseField {
    public $name = '';
    public $value = null;
    public $verbose_name = null;
    public $choices = null;
    public $widget = 'gdmin::widget.text';

    public function __construct($value=null, $verbose_name=null, $choices=null, $widget=null, $required=FALSE, $format = null){
        $this->value = $value;
        $this->verbose_name = $verbose_name;
        $this->choices = $choices;
        if($widget == null){
            $this->widget = $choices==null ? 'gdmin::widget.text' : 'gdmin::widget.select';
        }
        else{
            $this->widget = $widget;
        }
        $this->required = $required;
        $this->format = $format;
    }

    public function to_html($value=null){
        if(is_array($value)){
            return $this->array_to_html($value);
        }
        else if(is_object($value)){
            return $this->object_to_html($value);
        }
        else if(is_numeric($value)){
            return (string)$value;
        }
        else{
            return $value;
        }
    }

    public function object_to_html($value){
        return (string)$value;
    }

    public function array_to_html($value){
        $str_value = '';
        foreach($value as $v){
            $str_value = $str_value.','.$this->to_html($v);
        }
        return $str_value;
    }

    public function html(){
        return $this->to_html($this->value);
    }

    public function getDefault(){
        return $this->value;
    }

    public function validate($name){
        $value = \Input::get($name, null);
        if($value === null){
            return $this->getDefault();
        }
        return $this->formatValue($value);
    }

    public function formatValue($value){
        return $value;
    }

    public function __toString(){
        return $this->html();
    }
}
