<?php
/**
 * Created by PhpStorm.
 * User: snower
 * Date: 15/12/4
 * Time: 下午3:35
 */

namespace Gdmin\Filters;

class FloatFilter extends BaseFilter{
    public function formatValue($value){
        return floatval($value);
    }
} 