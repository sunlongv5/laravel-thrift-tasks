<?php
/**
 * Created by PhpStorm.
 * User: snower
 * Date: 16/1/20
 * Time: 上午11:38
 */

namespace Gdmin\Providers;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider{
    public function register(){
        $this->app->register(RouteServiceProvider::class);
    }
} 