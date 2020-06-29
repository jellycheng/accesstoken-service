<?php namespace App\Library\Enum;

/**
 * redis key前缀常量
 */
class RedisKeyEnum extends Enum
{
    const XCX_ACCESS_TOKEN_DATA = 'xcx:accesstoken:%s';//appid, 缓存小程序appid对应的令牌

}
