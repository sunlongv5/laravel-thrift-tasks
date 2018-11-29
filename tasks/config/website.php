<?php

return [
    'admin' => ['admin@ichunt.com'],

    'login' => [
        'login' => 'http://' . env('LOGIN_DOMAIN', '') . '/login',
        'logout'=> 'http://' . env('LOGIN_DOMAIN', '') . '/logout',
        'check' => 'http://' . env('LOGIN_DOMAIN', '') . '/api/checklogin',
        'search'=> 'http://' . env('LOGIN_DOMAIN', '') . '/api/search',
    ],

    'domain' => 'liexin.net',

    // crm
    'crm_url' => 'http://crm.liexin.net',
    // API项目
    'api_domain' => 'http://api.liexin.com/',
    // 获取用户权限接口
    'perm_api' => 'http://lperm.liexin.net/api/perms/',
    // 获取用户许可权限接口
    'check_access_api'  => 'http://lperm.liexin.net/api/perms/access',
    // 订单系统详情
    'order_details_url' => 'http://lorder.liexin.net/page/details/',
    // 会员系统详情
    'member_details_url' => 'http://lmember.liexin.net/page/jdOrderDetails/',
];
