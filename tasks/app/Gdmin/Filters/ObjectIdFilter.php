<?php
/**
 * Created by PhpStorm.
 * User: snower
 * Date: 15/12/4
 * Time: 下午3:17
 */

namespace Gdmin\Filters;

class ObjectIdFilter extends BaseFilter{
    public function formatValue($value){
        return new \MongoId($value);
    }

    public function isCurrent($value){
        return strval($this->current) == strval($value);
    }
} 