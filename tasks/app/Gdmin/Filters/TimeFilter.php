<?php
/**
 * Created by PhpStorm.
 * User: snower
 * Date: 15/12/4
 * Time: 下午6:54
 */

namespace Gdmin\Filters;

class TimeFilter extends DateTimeFilter{
    public function formatValue($value){
        return strtotime($value);
    }
} 