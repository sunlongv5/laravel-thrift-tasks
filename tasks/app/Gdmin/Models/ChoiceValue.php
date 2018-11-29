<?php
/**
 * Created by PhpStorm.
 * User: snower
 * Date: 16/7/28
 * Time: 下午4:58
 */

namespace Gdmin\Models;


class ChoiceValue {
    protected $choices;
    protected $key;

    public function __construct($choices, $key){
        $this->choices = $choices;
        $this->key = $key;
    }

    public function __toString(){

        return strval($this->choices->getVerboseName($this->key));
    }
} 