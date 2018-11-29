<?php

namespace sunlong\Thrift\Facades;

use Illuminate\Support\Facades\Facade;
use sunlong\Thrift\Contracts\ThriftClient as BaseThriftClient;

/**
 * @see \sunlong\Thrift\Contracts\ThriftClient
 */
class ThriftClient extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return BaseThriftClient::class;
    }
}
