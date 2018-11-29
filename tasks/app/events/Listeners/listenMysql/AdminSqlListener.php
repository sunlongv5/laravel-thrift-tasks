<?php
namespace Events\Listeners\listenMysql;


use Illuminate\Contracts\Queue\ShouldQueue;
use Log;
use Exception;
use Events\Models\AdminManagerModel;

class AdminSqlListener
{
    public function __construct()
    {

    }

    public function handle($host,$path,$method,$query_time,$sql)
    {
        try{
            $bk = AdminManagerModel::create([
                'host'=>$host,
                'path'=>$path,
                'method'=>$method,
                'query_time'=>floatval($query_time),
                'sql'=>$sql,
            ]);
            \Log::info('event执行成功');
            \Log::info((string)$bk);
        }catch(\Exception $e){
            \Log::info($e->getMessage());
        }

    }
}