<?php
/**
 * Created by PhpStorm.
 * User: snower
 * Date: 16/7/28
 * Time: 下午4:58
 */

namespace Gdmin\Models;


interface ChoicesInterface {
    public static function getChoices();

    public static function getChoicesKeyName();

    public static function formatChoicesKey($key);

    public function getChoicesKey();

    public function getChoicesVerboseName();
} 