<?php
/**
 * Created by PhpStorm.
 * User: sujian
 * Date: 14-8-30
 * Time: 上午10:13
 */

namespace Gdmin\Fields;

class ObjectIdField extends BaseField{

    const DEFAULT_MONGOID_VALUE = '000000000000000000000000';

    public function __construct($value=null, $verbose_name=null, $choices=null, $widget=null){
        parent::__construct($value === null ? new \MongoId(self::DEFAULT_MONGOID_VALUE) : $value, $verbose_name, $choices, $widget);
    }

    public function getDefault(){
        return $this->value instanceof \MongoId
            ? $this->value : new \MongoId(self::DEFAULT_MONGOID_VALUE);
    }

    public function validate($name){
        $value = \Input::get($name, null);
        return $this->formatValue($value);
    }

    public function formatValue($value){
        if($value === null or $value === ''){
            return new \MongoId(self::DEFAULT_MONGOID_VALUE);
        }
        return new \MongoId($value);
    }

    public function to_html($value=null){
        $value = strval($value);
        if($value == self::DEFAULT_MONGOID_VALUE){
            return '';
        }
        return $value;
    }
}
