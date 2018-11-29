<?php
namespace ListenMysql\Listen;
use Illuminate\Support\Facades\Facade;
class ListenMsql extends Facade{
    public static function getFacadeAccessor()
    {
        return 'listenmsql';
    }
}