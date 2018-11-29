<?php

namespace sunlong\Thrift;

use Illuminate\Support\ServiceProvider;

class ThriftServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('sunlong\Thrift\Contracts\ThriftServer', 'sunlong\Thrift\ThriftServerImpl');
        $this->app->singleton('sunlong\Thrift\Contracts\ThriftClient', 'sunlong\Thrift\ThriftClientImpl');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['sunlong\Thrift\Contracts\ThriftServer', 'sunlong\Thrift\Contracts\ThriftClient'];
    }
}
