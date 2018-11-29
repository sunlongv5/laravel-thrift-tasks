<?php
namespace Liexin\Http\Controllers;


use Events\Models\AdminManagerModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Liexin\Http\Requests;
use Liexin\Http\Controllers\Controller;
use DB;
use Cookie;
use Illuminate\Support\Facades\Redis;
use Illuminate\Container\Container as App;


Class CrmController extends Controller
{


    public function __construct(App $app)
    {
        $this->app = $app;
    }

    public function aabbcc(){
        $a = new AdminManagerModel();
//        dump($a);
        $bk = AdminManagerModel::create([
            'host'=>'192.168.1.188',
            'path'=>'/aabbcc',
            'method'=>'get',
            'query_time'=>floatval(0.25),
            'sql'=>'select * from crm',
        ]);
    }



}