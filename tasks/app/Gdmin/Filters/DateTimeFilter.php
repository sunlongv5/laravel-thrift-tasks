<?php
/**
 * Created by PhpStorm.
 * User: snower
 * Date: 15/12/4
 * Time: 下午3:17
 */

namespace Gdmin\Filters;

class DateTimeFilter extends BaseFilter{
    public function __construct($name, $verbose, $value, $choices = null, $widget='gdmin::widget.datetime_filter'){
        parent::__construct($name, $verbose, $value, $choices = null, $widget);

        $this->current = \Input::query($this->name, '');
        if($this->current == ''){
            $this->current = \Input::query($this->name."__gte", '');
        }
        if($this->current != ''){
            $this->current = $this->formatValue($this->current);
        }
    }

    public function initValue(){
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

        $this->keys[] = '全部';
        $this->values[] = '';

        $this->keys[] = '今天';
        $this->values[] = $this->name."__gte=".date('Y-m-d', time());

        $this->keys[] = '昨天';
        $this->values[] = $this->name."__gte=".date('Y-m-d', strtotime("-1 days"));

        $this->keys[] = '过去7天';
        $this->values[] = $this->name."__gte=".date('Y-m-d', strtotime("-7 days"));

        $this->inited = true;
        return true;
    }

    public function formatValue($value){
        return \Carbon\Carbon::createFromTimestamp(strtotime($value));
    }

    public function getQueryString($value){
        $inputs = \Input::query();
        $query = '';
        $has = FALSE;
        foreach($inputs as $key => $v){
            $keys = explode("__", $key);
            if($keys[0] == $this->name){
                $query = $query.$value."&";
                $has = TRUE;
            }
            else{
                $query = $query.$key."=".$v."&";
            }
        }
        if(!$has){
            $query = $query.$value."&";
        }
        return "?".$query;
    }

    public function getBaseQueryString(){
        $inputs = \Input::query();
        $query = '';
        foreach($inputs as $key => $v){
            $keys = explode("__", $key);
            if($keys[0] != $this->name){
                $query = $query.$key."=".$v."&";
            }
        }
        return "?".$query;
    }

    public function isCurrent($value){
        $current = \Input::query($this->name, '');
        if($current == ''){
            $current = \Input::query($this->name."__gte", '');
        }
        if($current == $value){
            return TRUE;
        }
        return $this->name."__gte=".$current === $value;
    }
} 