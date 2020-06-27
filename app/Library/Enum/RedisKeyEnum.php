<?php namespace App\Library\Enum;

/**
 * redis key前缀常量
 */
class RedisKeyEnum extends Enum
{
    const WE_CHAT_USER_SESSION_KEY = 'we_chat:session_key:%s'; //微信SessionKey
    const USER_CHK_LOGIN_FAIL_NUM = 'user:chk_login_fail_num:%s';//验证用户登录同一个token失败次数；%s对应用户ID

}
