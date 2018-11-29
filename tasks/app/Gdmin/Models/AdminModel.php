<?php
/**
 * Created by PhpStorm.
 * User: sujian
 * Date: 14-9-2
 * Time: 下午1:28
 */

namespace Gdmin\Models;

trait AdminModel {
    public static function getDefault(){
        $fields = static::getFields();
        $result = [];
        foreach($fields as $name => $field){
            $result[$name] = $field->getDefault();
        }
        return $result;
    }

    public static function formatData($data, $all_default=TRUE){
        $fields = static::getFields();
        $result = [];
        foreach($fields as $name => $field){
            if(array_key_exists($name, $data)){
                if($name == "_id"){
                    if(!$all_default){
                        continue;
                    }
                    elseif(empty($data["_id"]) || (string)$data["_id"] == '000000000000000000000000'){
                        continue;
                    }
                }
                $result[$name] = $data[$name];
            }
            else if($all_default){
                if($name == "_id"){
                    continue;
                }
                $result[$name] = $field->getDefault();
            }
        }
        return $result;
    }

//    public static function create(array $attributes = array()){
//        $data = static::formatData($attributes);
//        $data = parent::create($data);
//        return $data;
//    }
//
//    public function update(array $data = array()){
//        $data = static::formatData($data, FALSE);
//        $data = parent::update($data);
//        return $data;
//    }
} 