<?php
namespace App\Modules;

use \CjsLogin\QiyeWeixin\AccessToken;
use CjsRedis\Redis;
use App\Library\Enum\RedisExpireEnum;
use App\Library\Enum\RedisGroupEnum;
use App\Library\Enum\RedisKeyEnum;

class QyapiAccessTokenModule {

    // 获取企业微信的访问令牌
    public static function getQyapiAccessToken4redis($corpid, $secret = '') {
        $ret = [
                'code'=>0,
                'msg'=>'',
                'data'=>[],
        ];
        $redisKey = sprintf(RedisKeyEnum::QY_ACCESS_TOKEN_DATA, md5($corpid.$secret));
        $redisDataTmp = Redis::get(RedisGroupEnum::ACCESS_TOKEN, $redisKey);
        if($redisDataTmp) {
            $redisData = \json_decode($redisDataTmp, true);
            $difVal = time() - $redisData['append_create_time'];
            unset($redisData['append_create_time']);
            unset($redisData['errcode']);
            unset($redisData['errmsg']);
            $redisData['expires_in'] = $redisData['expires_in'] - $difVal;
            if($redisData['expires_in']>=30) {//误差30秒内就放弃，之外就返回
                $ret['code'] = 0;
                $ret['data'] = $redisData;
                return $ret;
            }
        }

        $retRes = AccessToken::get($corpid, $secret);
        if(isset($retRes['access_token'])) {//成功
            $ret['code'] = 0;
            unset($retRes['errcode']);
            unset($retRes['errmsg']);
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


    // 清除缓存在redis中的企业微信访问令牌
    public static function clearQyapiAccessToken4redis($corpid,$secret) {
        $redisKey = sprintf(RedisKeyEnum::QY_ACCESS_TOKEN_DATA, md5($corpid.$secret));
        $isOk = Redis::del(RedisGroupEnum::ACCESS_TOKEN, $redisKey);
        return $isOk?true:false;
    }


}
