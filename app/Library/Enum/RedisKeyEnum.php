<?php namespace App\Library\Enum;

/**
 * redis key前缀常量
 */
class RedisKeyEnum extends Enum
{
    const XCX_ACCESS_TOKEN_DATA = 'xcx:%s';//appid, 缓存小程序appid对应的令牌
    const QY_ACCESS_TOKEN_DATA = 'qyapi:%s';//md5(企业ID.应用密钥), 缓存企业微信应用对应的令牌
}
