<?php
/**
 * Created by PhpStorm.
 * User: snower
 * Date: 16/7/28
 * Time: 下午5:00
 */

namespace Gdmin\Models;


trait AdminChoices {
    public static function getChoices(){
        return new Choices(static::class);
    }

    public static function formatChoicesKey($key){
        return $key;
    }

    public function getChoicesKey(){
        return $this->{$this->getChoicesKeyName()};
    }

    public function getChoicesVerboseName(){
        return $this->getVerboseName();
    }
} 