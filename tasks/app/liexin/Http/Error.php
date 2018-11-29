<?php

namespace Liexin\Http;

class Error
{
    const E_PARAM       = -10001; // 参数错误
    const E_DB          = -10002; // 数据库错误
    const E_NOT_EXISIT  = -10003; // 数据不存在
    const E_FORBIDDEN   = -10004; // 权限限制
    const E_STATUS      = -10005; // 数据状态不一致
    const E_AUDIT_EXIST = -10006; // 有相同的权限申请
    const E_NOT_LOGIN   = -10007; // 未登陆
    const E_SERVER      = -10008; // 服务错误
    const E_NOT_EXISTS  = -10009; // 不存在
    const E_NO_ACCESS   = -10010; // 无权访问
};
