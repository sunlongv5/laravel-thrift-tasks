<?php

return [
    // 是否开启报错写入
    'enabled' => env('DING_ALERT', false),

    // curl证书验证, 线下环境不用开启
    'curl_verify' => true,

    'web_name'=>'crm系统错误[请及时修改]',

    // webhook的值
    'webhook' => 'https://oapi.dingtalk.com/robot/send?access_token=41bc0f48b8d4686066ef45194346f832de2d1179960a4db7ecdcf6899563faee',
];