<?php
/**
 * Created by PhpStorm.
 * User: sujian
 * Date: 14-8-30
 * Time: 上午10:00
 */

namespace Gdmin\Fields;

class StringField extends BaseField{
    public function __construct($value=null, $verbose_name=null, $choices=null, $widget=null){
        parent::__construct($value === null ? '' : $value, $verbose_name, $choices, $widget);

        $this->widget = 'gdmin::widget.textarea';
    }

    public function getDefault(){
        return $this->value === null ? '' : $this->value;
    }
}
