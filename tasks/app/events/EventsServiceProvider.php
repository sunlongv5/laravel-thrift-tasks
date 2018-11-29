<?php namespace Events;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Support\ServiceProvider;
use Events\Listeners\listenMysql\AdminSqlListener;

use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Queue\MongoConnector;

class EventsServiceProvider extends ServiceProvider
{
    public function boot(DispatcherContract $events) {
        //监听网站sql语句
        $events->listen("listen.add.mysql", AdminSqlListener::class);
    }

    public function register(){

    }

}
