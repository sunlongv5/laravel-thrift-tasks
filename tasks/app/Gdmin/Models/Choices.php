<?php
/**
 * Created by PhpStorm.
 * User: snower
 * Date: 16/7/27
 * Time: 下午4:56
 */

namespace Gdmin\Models;

class Choices implements \ArrayAccess , \Iterator {
    protected $model;
    protected $key_maps = [];
    protected $keys = [];
    protected $items = [];
    protected $current_index = 0;
    protected $loaded = false;

    public function __construct($model){
        $this->model = $model;
    }

    protected function loadAllItems(){
        $model = $this->model;
        $items = $model::all();

        $this->keys = [];
        $this->key_maps = [];
        $this->items = [];
        foreach($items as $item){
            $key = $this->formatChoicesKey($item->getChoicesKey());
            $this->keys[] = $key;
            $this->key_maps[$key] = count($this->keys);
            $this->items[$key] = $item->getChoicesVerboseName();
        }
        $this->loaded = true;
    }

    protected function loadItems($key){
        $model = $this->model;
        if($key == null){
            $items = $model::whereIn($model::getChoicesKeyName(), $this->keys)->get();
            foreach($items as $item){
                $this->items[$this->formatChoicesKey($item->getChoicesKey())] = $item->getChoicesVerboseName();
            }
            $this->loaded = true;
        }
        else{
            $item = $model::where($model::getChoicesKeyName(), "=", $key)->first();
            if($item){
                $this->items[$this->formatChoicesKey($item->getChoicesKey())] = $item->getChoicesVerboseName();
            }
            else{
                $this->items[$this->formatChoicesKey($key)] = null;
            }
        }
    }

    protected function formatChoicesKey($key){
        return is_object($key) ? (string)$key : ((!is_string($key) && is_numeric($key)) ? intval($key) : $key);
    }

    public function getVerboseName($key){
        if(!$this->loaded && !empty($this->keys)){
            $this->loadItems(null);
        }
        else if(!isset($this->items[$key]) && empty($this->keys)){
            $this->loadItems($key);
        }
        return isset($this->items[$key]) ? $this->items[$key] : $key;
    }

    public function offsetSet($offset, $value) {
        $key = $this->formatChoicesKey($offset);
        $this->items[$key] = $value;
    }

    public function offsetExists($offset) {
        $model = $this->model;
        $key = $this->formatChoicesKey($offset);
        if(!$this->loaded && !empty($this->keys)){
            $this->loadItems(null);
        }
        else if(!isset($this->items[$key]) && empty($this->keys)){
            $this->loadItems($model::formatChoicesKey($offset));
        }

        return isset($this->items[$key]) && $this->items[$key];
    }

    public function offsetUnset($offset) {
        $key = $this->formatChoicesKey($offset);;
        unset($this->keys[$this->key_maps[$key] -1]);
        unset($this->key_maps[$key]);
    }

    public function offsetGet($offset) {
        $model = $this->model;
        $key = $this->formatChoicesKey($offset);;
        if(!isset($this->key_maps[$key])){
            $this->keys[] =  $model::formatChoicesKey($offset);
            $this->key_maps[$key] = count($this->keys);
        }
        return new ChoiceValue($this, $key);
    }

    public function key() {
        if($this->current_index == 0){
            if(!$this->loaded){
                $this->loadAllItems();
            }
        }

        if(!isset($this->keys[$this->current_index])){
            return null;
        }
        return $this->keys[$this->current_index];
    }

    public function current() {
        return new ChoiceValue($this, $this->key());
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
        $key = $this->key();
        if($key == null){
            return false;
        }

        return isset($this->items[$key]);
    }
}