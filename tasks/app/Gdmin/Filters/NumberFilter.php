<?php
/**
 * Created by PhpStorm.
 * User: snower
 * Date: 15/12/4
 * Time: 下午3:35
 */

namespace Gdmin\Filters;

class NumberFilter extends BaseFilter{
    public function formatValue($value){
        return intval($value);
    }
} 