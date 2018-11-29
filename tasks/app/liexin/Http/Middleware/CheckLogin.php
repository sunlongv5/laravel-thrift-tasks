<?php

namespace Liexin\Http\Middleware;

use Closure;
use App\Http\Output;
use App\Http\Error;
use Config;
use App\Http\Controllers\PermController;

class CheckLogin
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
        $userId = $request->cookie('oa_user_id');
        $skey   = $request->cookie('oa_skey');
        $isApi  = false;
        $pos    = strpos($request->path(), 'api/');

        if ($pos === 0)
            $isApi = true;

        $login = Config::get('website.login');
        if (!$userId || !$skey || (string)((int)$userId) != $userId || !preg_match('/^[a-zA-Z0-9]+$/', $skey)) {
            if ($isApi) {
                errorLog(E_NOT_LOGIN, "not login"); // 记录到日志文件
                return Output::makeResult($request, Error::E_NOT_LOGIN, "not login");
            }
            return redirect($login['login'] . '?redirect=' . urlencode($request->url()));
        }

        $cookie = 'oa_user_id=' . $userId . '; oa_skey=' . $skey;
        $client = new \GuzzleHttp\Client();
        $rsp = $client->request('GET', $login['check'], [
            'headers'           => ['Cookie' => $cookie],
            'connect_timeout'   => 1,
            'timeout'           => 3
        ]);

        if ($rsp->getStatusCode() != 200) {
            Log::error("query {$login['check']} failed: code " . $rsp->getStatusCode());
            if ($isApi) {
                errorLog(E_SERVER, "login server error"); // 记录到日志文件
                return Output::makeResult($request, Error::E_SERVER, "login server error: status code = " . $rsp->getStatusCode());
            }
            abort(500);
        }

        $ret = json_decode($rsp->getBody());
        if ($ret->retcode != 0) {
            if ($isApi)
                return ["errcode" => $ret->retcode, "errmsg" => $ret->errMsg];
            return redirect($login['login'] . '?redirect=' . urlencode($request->url()));
        }

        $user = $ret->data;
        $user->header = $request->cookie('oa_header');
        $request->user = $user;

        // 判断用户访问权限
        $perm = new PermController;

        $access = $perm->checkAccess($request);
        $business = $perm->getBusinessInfo();

        if (!$access) {
            return view('no_access', ['bid'=>$business->bid]); // 返回无权限模板
        }

        return $next($request);
    }
}
