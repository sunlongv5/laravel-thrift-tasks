<?php
namespace Events\Models;
use Gdmin\Models\AdminModel;
use Gdmin\Models\AdminChoices;
use Jenssegers\Mongodb\Eloquent\Model;
use Gdmin\Models\ModelFieldsInterface;
use Gdmin\Models\ChoicesInterface;

class MongoModel extends Model implements ModelFieldsInterface, ChoicesInterface{
    const CREATED_AT = 'crts';
    const UPDATED_AT = 'upts';
    protected static $unguarded = true;

    use AdminModel;
    use AdminChoices;

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

    public function getDotId() {
        return 2;
    }
} 