<?php

namespace Liexin\Http;
use Illuminate\Http\Request;

class Output
{
    public static function makeResult(Request $req, $retcode, $errmsg=null, $data=null)
    {
        $ret = [ 'retcode' => $retcode ];
        if ($errmsg !== null)
            $ret['errMsg'] = $errmsg;
        if ($data !== null)
            $ret['data'] = $data;

        return $ret;
    }
};
