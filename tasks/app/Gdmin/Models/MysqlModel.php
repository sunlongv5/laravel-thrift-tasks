<?php
/**
 * Created by PhpStorm.
 * User: snower
 * Date: 16/7/27
 * Time: 下午4:55
 */

namespace Gdmin\Models;

use Illuminate\Database\Eloquent\Model;

class MysqlModel extends Model implements ModelFieldsInterface{
    protected static $unguarded = true;
    
    use AdminModel;
    use AdminChoices;

    public static function getChoicesKeyName(){
        return "id";
    }

    public static function formatChoicesKey($key){
        return $key;
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