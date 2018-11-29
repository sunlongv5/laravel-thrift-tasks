<?php
namespace ListenMysql\Listen;
use DB;
use Log;
use Event;
use App;

class AddEveryMysql{
    public  $config = [];
    public  $allList = [];
    public function __construct($config=[])
    {
        $this->config = $config;
    }


    public function listen(){
        try{
            if(!isset($this->config['enabled']) || !$this->config['enabled']) return false;
            $querys  =  [
                'urls'=>['host'=>app('request')->server('HTTP_HOST'),'path'=>app('request')->path(),'method'=>app('request')->method()],
                'datas'=>[],
            ];
            $host = app('request')->server('HTTP_HOST');
            $path =  app('request')->path();
            $method = app('request')->method();
            $arr = new static;
            @DB::listen(function($query)use($querys,$arr){
                $tmp = str_replace('?', '"'.'%s'.'"', $query->sql);
                $tmp = vsprintf($tmp, $query->bindings);
                $tmp = str_replace("\\","",$tmp);
                \Log::info("host {$querys['urls']['host']} url:{$querys['urls']['path']} method:".$querys['urls']['method']." [queryTime:{$query->time}ms]".$tmp."\n\n\t");
                $arr->add("123");
            });


        }catch(\Exception $e){

        }
    }

    public function add($str){
        $this->allList[] = $str;
    }
}