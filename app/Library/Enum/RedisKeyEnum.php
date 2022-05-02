<?php namespace App\Library\Enum;

/**
 * redis key前缀常量
 */
class RedisKeyEnum extends Enum
{
    const XCX_ACCESS_TOKEN_DATA = 'xcx:%s';//appid, 缓存小程序appid对应的令牌
    const QY_ACCESS_TOKEN_DATA = 'qyapi:%s';//md5(企业ID.应用密钥), 缓存企业微信应用对应的令牌
    const WE_CHAT_JS_API_TICKET = 'wechat:js_api:%s';//缓存 js-sdk接口返回的js_api_ticket信息，key格式：wechat:js_api:appid值
}
