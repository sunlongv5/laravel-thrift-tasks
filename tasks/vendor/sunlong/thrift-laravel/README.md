# thrift-laravel

use Thrift in Laravel

# How to use

## Server side

1. `composer require sunlong/thrift-laravel`
2. add provider to `app.providers`:
    ````
    \sunlong\Thrift\ThriftServiceProvider::class
    ````
3. setting `thrift.providers` in file `config/thrift.php`:
    ````
    // first is service name, defined in thrift file
    // second in Service implement reference, e.g.
    // class ImageServcie implement \sunlong\ImageServiceIf
    ['sunlong.ImageService', \sunlong\ImageService::class],
    ````
4. add Middleware `\sunlong\Thrift\Middleware\ThriftServerMiddleware::class` to `app\Http\Kernel`

    in default, the request to `/rpc` will be process by Middleware,
    if you want to change this, please extend `ThriftServerMiddleware` and overwrite `process` method

## Client side

1. `composer require sunlong/thrift-laravel`
2. add provider in `app.providers`:
    ````
    \sunlong\Thrift\ThriftServiceProvider::class
    ````
3. setting `thrift.depends` in file `config/thrift.php`:
    ````
    // key is url
    // value is array of service name
    "http://localhost/rpc" => [
        'sunlong.ImageService',
    ]
    ````
4. usage:
    ````
    /** @var \sunlong\Thrift\Contracts\ThriftClient $thriftClient */
    $thriftClient = app(\sunlong\Thrift\Contracts\ThriftClient::class);
    /** @var \sunlong\ImageServiceIf $imageService */
    $imageService = $thriftClient->with('sunlong.ImageService');
    
    $result = $imageService->foo();
    ````

# TODO

* Unittest
