<?php
/**
 * Created by PhpStorm.
 * User: jelly
 * Date: 2022/5/2
 * Time: 21:10
 */

namespace App\Modules;

use App\Library\Enum\RedisExpireEnum;
use App\Library\Enum\RedisGroupEnum;
use App\Library\Enum\RedisKeyEnum;
use App\Library\Exceptions\ServiceException;
use App\Modules\Base;
use App\Util\Unique;
use CjsRedis\Redis;


class JsSDKModule extends Base
{

    public static function getJsApiSign($param)
    {
        $appid = "";
        if(isset($param['wx_app_id'])) {
            $appid = $param['wx_app_id'];
        }
        $secret = "";
        if(isset($param['wx_app_secret'])) {
            $secret = $param['wx_app_secret'];
        }
        $tmp = AccessTokenModule::getXcxAccessToken4redis($appid, $secret);
        if($tmp['code']!=0) {
            throw new ServiceException($tmp['msg'], $tmp['code']);
        }
        # 获取AccessToken
        $access_token_info = $tmp['data'];
        # 获取JsApiSignInfo信息
        return self::JsApiSignInfo($appid, $access_token_info['access_token'], $param['url']);
    }

    protected static function JsApiSignInfo($app_id, $access_token, $url)
    {
        $jsapi_ticket = self::getJsApiTicketInfo($app_id, $access_token);
        $time = time();
        $random_code  = Unique::randStr(8);
        $signature = self::getSignature($jsapi_ticket['ticket'], $url, $random_code, $time);
        return [
            'app_id'    => $app_id,
            'noncestr'  => $random_code,
            'timestamp' => $time,
            'signature' => $signature
        ];
    }

    protected static function getJsApiTicketInfo($app_id, $access_token)
    {
        # 在Redis中获取JsApiTicket信息
        $ret = self::getRedisJsApiTicketInfo($app_id);
        if (empty($ret)) {
            # 请求微信开放平台获取access_token信息
            $data = self::getWxJsApiTicket($access_token);
            if (!empty($data)) {
                $data['create_time'] = time();
                # 将JsApiTicket信息存入Redis中
                self::setRedisJsApiTicketInfo($data, $app_id);
                $ret = $data;
            }
        }
        # 过期时间
        $ret['expires_in'] = RedisExpireEnum::EXPIRE_HOUR_TWO + $ret['create_time'] - time();
        return $ret;
    }

    protected static function getSignature($js_api_ticket, $url, $random_code, $time)
    {
        $str = sprintf('jsapi_ticket=%s&noncestr=%s&timestamp=%s&url=%s', $js_api_ticket, $random_code, $time, $url);
        //Log::debug(__METHOD__ . ' 签名字符串', [$str]);
        return sha1($str);
    }

    protected static function getRedisJsApiTicketInfo($wx_app_id)
    {
        $redis_key  = sprintf(RedisKeyEnum::WE_CHAT_JS_API_TICKET, $wx_app_id);
        $redis_data = Redis::get(RedisGroupEnum::ACCESS_TOKEN, $redis_key);
        return $redis_data ? json_decode($redis_data, true) : [];
    }

    protected static function setRedisJsApiTicketInfo($ticket_info, $wx_app_id)
    {
        $redisKey = sprintf(RedisKeyEnum::WE_CHAT_JS_API_TICKET, $wx_app_id);
        Redis::set(RedisGroupEnum::ACCESS_TOKEN, $redisKey, json_encode($ticket_info), RedisExpireEnum::EXPIRE_HOUR_TWO - 200);
    }

    protected static function getWxJsApiTicket($access_token)
    {
        $param = [
            'access_token' => $access_token,
            'type' => 'jsapi',
        ];
        //Log::debug(__METHOD__ . ' 获取微信Ticket参数', [$param]);
        $ret = AccessTokenModule::getWeChatInfo($param, '/cgi-bin/ticket/getticket');
        //Log::debug(__METHOD__ . ' 微信Ticket返回', [$ret]);
        return $ret;
    }

}