<?php
/**
 * Created by PhpStorm.
 * User: snower
 * Date: 15/12/4
 * Time: 下午3:17
 */

namespace Gdmin\Filters;

use Gdmin\Models\Choices;

class BaseFilter implements \Iterator{
    public function __construct($name, $verbose_name, $value, $choices = null, $widget='gdmin::widget.base_filter'){
        $this->name = $name;
        $this->verbose_name = $verbose_name;
        $this->value = $value;
        $this->choices = $choices;
        $this->widget = $widget;

        $this->keys = [];
        $this->values = [];
        $this->current_index = 0;
        $this->inited = false;

        $this->current = \Input::query($this->name, '');
        if($this->current != ''){
            $this->current = $this->formatValue($this->current);
        }
    }

    public function initValue() {
        $this->keys = [];
        $this->values = [];
        $this->current_index = 0;

        if(is_array($this->value)){
            foreach($this->value as $key => $value){
                $this->keys[] = $key;
                $this->values[] = $value;
            }

            $this->inited = true;
            return false;
        }
        $model = $this->value;

        $this->keys[] = '全部';
        $this->values[] = '';

        if(is_array($this->choices) || $this->choices instanceof Choices){
            foreach($this->choices as $key => $value){
                $this->keys[] = $value;
                $this->values[] = $key;
            }
        }
        else {
            foreach ($model::select($this->name)->distinct()->get() as $model) {
                $attributes = array_values($model->getAttributes());
                $value = $this->formatValue($attributes[0]);

                $this->keys[] = $value;
                $this->values[] = $value;
            }
        }

        $this->inited = true;
        return true;
    }

    public function formatValue($value){
        return $value;
    }

    public function parseExp(){
        $inputs = \Input::query();
        foreach($inputs as $key => $value){
            $keys = explode("__", $key);
            if($keys[0] == $this->name) {
                if($value == ''){
                    break;
                }

                if (count($keys) <= 1) {
                    return [$this->formatValue($value), '='];
                }
                $exp = $keys[1];
                switch ($exp) {
                    case 'gt':
                        return [$this->formatValue($value), '>'];
                    case 'gte':
                        return [$this->formatValue($value), '>='];
                    case 'lt':
                        return [$this->formatValue($value), '<'];
                    case 'lte':
                        return [$this->formatValue($value), '<='];
                    case 'in':
                        $values = [];
                        foreach (explode(",", $value) as $v) {
                            $values[] = $this->formatValue($v);
                        }
                        return [$values, "in"];
                    default:
                        return [$this->formatValue($value), '='];
                }
            }
        }
        return [null, ''];
    }

    public function makeQuery($query){
        list($value, $exp) = $this->parseExp();
        if($value !== null) {
            if($exp == "in"){
                return $query->whereIn($this->name, $value);
            }
            return $query->where($this->name, $exp, $value);
        }
        return $query;
    }

    public function getQueryString($value){
        $inputs = \Input::query();
        $query = '';
        $has = FALSE;
        foreach($inputs as $key => $v){
            if($v == ''){
                continue;
            }

            if($key == $this->name){
                $query = $query.$this->name."=".$value."&";
                $has = TRUE;
            }
            else{
                $query = $query.$key."=".$v."&";
            }
        }
        if(!$has){
            $query = $query.$this->name."=".$value."&";
        }
        return "?".$query;
    }

    public function isCurrent($value){
        return $this->current === $value;
    }

    public function key() {
        if(!$this->inited){
            $this->initValue();
        }
        return $this->keys[$this->current_index];
    }

    public function current() {
        if(!$this->inited){
            $this->initValue();
        }
        return $this->values[$this->current_index];
    }

    public function next() {
        $this->current_index++;
    }

    public function rewind() {
        $this->current_index = 0;
    }

    public function seek($position) {
        $this->current_index = $position;
    }

    public function valid() {
        if(!$this->inited){
            $this->initValue();
        }
        return isset($this->keys[$this->current_index]);
    }
}