<?php
/**
 * Created by PhpStorm.
 * User: snower
 * Date: 15/12/4
 * Time: 下午6:56
 */

namespace Gdmin\Fields;

class DateTimeField extends BaseField{
    public function __construct($value=null, $verbose_name=null, $choices=null, $widget=null){
        parent::__construct($value === null ? time() : $value, $verbose_name, $choices, $widget);

        if($widget === null){
            $this->widget = 'gdmin::widget.datetime';
        }
        $this->format = "default_format_datetime";
    }

    public function getDefault(){
        return $this->value === null ? \Carbon\Carbon::now() : $this->value;
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
            return \Carbon\Carbon::createFromTimestamp(intval($value));
        }
        else{
            return \Carbon\Carbon::createFromTimestamp(strtotime($value));
        }
    }

    public function to_html($value=null)
    {
        if ($value instanceof \Carbon\Carbon) {
            return $value->toDateTimeString();
        }
        if ($value === 0){
            return "0000-00-00 00:00:00";
        }
        return date('Y-m-d H:i:s', is_numeric($value) ? $value : time());
    }
}
