<?php
namespace ListenMysql\Listen;

use Illuminate\Support\ServiceProvider;

class ListenMysqlServiceProvider extends ServiceProvider {

    /**
     * Boot the provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config.php' => config_path('listenMysql.php'),
        ]);

    }


    /**
     * 在容器中注册绑定.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(AddEveryMysql::class, function ($app) {
            $config = config('listenMysql');
            return new AddEveryMysql($config);
        });
        app(AddEveryMysql::class)->listen();
    }
}