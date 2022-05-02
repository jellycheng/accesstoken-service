<?php
namespace App\Modules;

use CjsLogin\Xcx\AccessToken;
use CjsRedis\Redis;
use App\Library\Enum\RedisExpireEnum;
use App\Library\Enum\RedisGroupEnum;
use App\Library\Enum\RedisKeyEnum;
use App\Library\Exceptions\ServiceException;
use App\Library\Enum\ExceptionCodeEnum;
use App\Util\Curl;

class AccessTokenModule {

    //获取小程序的访问令牌
    public static function getXcxAccessToken4redis($appid, $secret = '') {
        $ret = [
                'code'=>0,
                'msg'=>'',
                'data'=>[],
        ];
        if(!$secret) {//获取代码中配置的密钥,todo
            $tmpKey = "THIRD_APPID_" . $appid;
            $secret = env($tmpKey, "");
        }
        $redisKey = sprintf(RedisKeyEnum::XCX_ACCESS_TOKEN_DATA, $appid);
        $redisDataTmp = Redis::get(RedisGroupEnum::ACCESS_TOKEN, $redisKey);
        if($redisDataTmp) {
            $redisData = \json_decode($redisDataTmp, true);
            $difVal = time() - $redisData['append_create_time'];
            unset($redisData['append_create_time']);
            $redisData['expires_in'] = $redisData['expires_in'] - $difVal;
            if($redisData['expires_in']>=30) {//误差30秒内就放弃，之外就返回
                $ret['code'] = 0;
                $ret['data'] = $redisData;
                return $ret;
            }
        }

        $retRes = AccessToken::get($appid, $secret);
        if(isset($retRes['access_token'])) {//成功
            $ret['code'] = 0;
            $ret['data'] = $retRes;
            //设置redis
            $retRes['append_create_time'] = time(); //额外追加的参数，放入缓存时间
            Redis::set(RedisGroupEnum::ACCESS_TOKEN, $redisKey,\json_encode($retRes),RedisExpireEnum::EXPIRE_HOUR_THEE);
        } else if(isset($retRes['errcode'])) {
            $ret['code'] = $retRes['errcode'];
            $ret['msg'] = $retRes['errmsg'];
        } else {
            $ret['code'] = 1;
            $ret['msg'] = "网络异常";
        }
        
        
        return $ret;
    }


    //清除缓存在redis中的小程序访问令牌
    public static function clearXcxAccessToken4redis($appid) {
        $redisKey = sprintf(RedisKeyEnum::XCX_ACCESS_TOKEN_DATA, $appid);
        $isOk = Redis::del(RedisGroupEnum::ACCESS_TOKEN, $redisKey);
        return $isOk?true:false;
    }

    public static function getOauthAccessToken($param)
    {
        if (empty($param['code'])) {
            throw new ServiceException('code必传', ExceptionCodeEnum::INVALID_ARGUMENT);
        }
        $ret = [];
        if (!empty($param['code'])) {
            $appid = $param["wx_app_id"];
            $secret = "";
            if(isset($param["wx_app_secret"])) {
                $secret = $param["wx_app_secret"];
            }
            if(!$secret) {//获取代码中配置的密钥
                $tmpKey = "THIRD_APPID_" . $appid;
                $secret = env($tmpKey, "");
            }
            $wxConfig = [
                    'appid'=>$appid,
                    'appsecret'=>$secret,
                ];
            $wxObj = \CjsLogin\Weixin\WxWeb::create()->setWxConfig($wxConfig);
            $ret = $wxObj->getWebAccessToken($param['code'], $appid, $secret);
            if($wxObj->getErrno()) {
                throw new ServiceException($wxObj->getErrmsg(), $wxObj->getErrno());
            }
        }
        return $ret;
    }

    public static function getWeChatInfo($param, $route, $method = 'GET')
    {
        $ret = [];
        $url = sprintf('%s%s', env('DOMAIN_WECHAT_HOST', 'https://api.weixin.qq.com'), $route);
        //Log::debug('请求URL', [$url, $param]);
        $data = Curl::request($url, $param, $method, $timeout = Curl::REQUEST_TIMEOUT);
        //Log::debug(__METHOD__ . ' 微信公众服务平台CURL返回', [$data]);
        if (0 == $data['code'] && !empty($data['data'])) {
            $ret = json_decode($data['data'], true);
            if (!empty($ret['errcode'])) {
                //Log::debug(__METHOD__ . ' 微信公众服务平台异常信息', [$ret]);
                throw new ServiceException('微信公众服务平台异常返回 ' . $ret['errmsg'], ExceptionCodeEnum::FAIL);
            }
        }
        return $ret;
    }

}
