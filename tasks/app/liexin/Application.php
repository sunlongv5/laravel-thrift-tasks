<?php namespace Liexin;

use Closure;
use Illuminate\Foundation\Application as ApplicationBase;
use Liexin\Providers\EventServiceProvider;
use Illuminate\Routing\RoutingServiceProvider;

class Application extends ApplicationBase
{
    public function path()
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'app' . DIRECTORY_SEPARATOR . 'liexin';
    }


}