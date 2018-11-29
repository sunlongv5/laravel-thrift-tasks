<?php
/**
 * Created by PhpStorm.
 * User: snower
 * Date: 16/7/27
 * Time: 下午4:55
 */

namespace Gdmin\Models;

use \Jenssegers\Mongodb\Model;

class MongoModel extends Model implements ModelFieldsInterface, ChoicesInterface{
    const CREATED_AT = 'crts';
    const UPDATED_AT = 'upts';
    protected static $unguarded = true;

    use AdminModel;
    use AdminChoices;

    public function freshTimestamp()
    {
        if(static::UPDATED_AT == 'upts'){
            return time();
        }
        return parent::freshTimestamp();
    }

    public function fromDateTime($value)
    {
        if(is_numeric($value)){
            return $value;
        }
        return parent::fromDateTime($value);
    }

    public static function getChoicesKeyName(){
        return "_id";
    }

    public static function formatChoicesKey($key){
        return new \MongoId($key);
    }

    public static function getFields(){
        return [];
    }

    public function getPrimaryValue(){
        return $this->getKey();
    }

    public function getVerboseName(){
        return $this->getPrimaryValue();
    }
} 