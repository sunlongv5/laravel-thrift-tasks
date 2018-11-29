<?php
namespace Rpc\Event;

use Rpc\Event\EventIf;
use Event;

class EventHandler implements EventIf{
    public function emit($json){
        \Log::info(json_decode($json,true));
        return '123456789';
        try{
            $arr = json_decode($json,true);
//            Event::fire($arr['msg'],$arr['params']);
        }catch(\Exception $e){
            return false;
        }
        return true;
    }
}