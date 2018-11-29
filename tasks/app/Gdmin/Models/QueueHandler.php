<?php
/**
 * Created by PhpStorm.
 * User: snower
 * Date: 17/7/26
 * Time: 下午5:07
 */

namespace Gdmin\Queue;

use Illuminate\Queue\InteractsWithQueue;

class QueueHandler{
    use InteractsWithQueue;

    protected function retry($delay = 300, $max_retry_count = 3, $key = ''){
        $event = $this->job->getEvent();
        $params = $this->job->getParams();

        if(!strpos($event,"@")){
            $event = $event . '@' . str_replace("\\", '.', self::class);
        }

        if(isset($params["__retry_count"])){
            if($params["__retry_count"] >= $max_retry_count){
                return false;
            }
            $params["__retry_count"] +=1;
        }else{
            $params["__retry_count"] = 1;
        }

        $seconds = $delay % 60;
        $minutes = intval($delay / 60) % 60;
        $hours = intval($delay / 3600) % 24;
        $days = intval($delay / 86400);

        if(empty($key)){
            $key = "mis:retry:" . str_replace(".", ':', $event) . ':' . strval(new \MongoId());
        }

        app("rpc.ecrontab")->createTimeout($key, $seconds, $minutes, $hours, $days, 0, 0, 1, "event", json_encode([
            "event" => $event,
            "params" => $params
        ]));
        \Log::info("retry event $event $delay");
        return true;
    }
} 