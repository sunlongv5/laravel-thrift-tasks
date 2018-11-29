<?php

namespace Liexin\Http\Middleware;

use Closure;
use App\Http\Output;
use App\Http\Controllers\LoginController;
use App\Http\Error;
use Config;

class JsonpCallback
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $callback = $request->input('callback', null);
        $result = $next($request);
        if (!$callback)
            return $result;

        if (strpos($request->path(), 'api/') !== 0)
            return $result;
        if (!preg_match('/^[_A-Za-z0-9]+$/', $callback))
            return $result;

        if (is_array($result)) {
            $result = $callback . '(' . json_encode($result) . ')';
        } else {
            $result->setContent($callback . '(' . $result->content() . ')');
        }

        return $result;
    }
}
