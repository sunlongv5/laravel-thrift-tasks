<?php
/**
 * Created by PhpStorm.
 * User: snower
 * Date: 16/7/27
 * Time: 下午4:41
 */

namespace Gdmin\Models;


interface ModelFieldsInterface {
    public static function getFields();

    public static function getDefault();

    public static function formatData($data, $all_default=TRUE);

    public function getPrimaryValue();

    public function getVerboseName();
} 