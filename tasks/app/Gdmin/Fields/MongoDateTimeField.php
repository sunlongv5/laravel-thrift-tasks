<?php
namespace Gdmin\Fields;

use MongoDB\BSON\UTCDatetime as MongoDate;
use  Gdmin\Fields\BaseField;
class MongoDateTimeField extends BaseField{
    public function __construct($value=null, $verbose_name=null, $choices=null, $widget=null){
        parent::__construct($value === null ? time() : $value, $verbose_name, $choices, $widget);
    }

    public function getDefault(){
        if (! $this->value instanceof MongoDate) {
            if (is_string($this->value)) {
                $this->value = new MongoDate(strtotime($this->value));
            } else {
                $this->value = null;
            }
        }
        return $this->value === null ? (new MongoDate()) : $this->value;
    }
}
