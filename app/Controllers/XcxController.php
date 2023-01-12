<?php
namespace App\Controllers;

use CjsLogin\Xcx\WeixinXcx;

class XcxController extends Base
{
    // 通过小程序登录的code获取openid
    public function jscode2sessionAction()
    {
        $ret = [
            'code'=>0,
            'msg'=>'',
            'data'=>[],
        ];
        $appid = isset($_GET['appid'])?$_GET['appid']:'';
        $secret = isset($_GET['secret'])?$_GET['secret']:'';
        $code = isset($_GET['code'])?$_GET['code']:'';
        if(!$appid) {
            return $this->responseError(1, "appid参数值不能为空");
        }
        if(!$secret) {//获取代码中配置的密钥
            $tmpKey = "THIRD_APPID_" . $appid;
            $secret = env($tmpKey, "");
        }
        if(!$code) {
            return $this->responseError(1, "code参数值不能为空");
        }
        $cxcParam = [
            'appid'=>$appid,     //小程序的 app id
            'appsecret'=>$secret,//小程序的 app secret
            'code'=>$code,  //登录时获取的 code,一个code只能验证一次
        ];
        $xcxInfo = WeixinXcx::jscode2session($cxcParam);
        if($xcxInfo) {
            $xcxInfoAry = json_decode($xcxInfo, true);
            $openid = isset($xcxInfoAry['openid'])?$xcxInfoAry['openid']:"";
            if(!$openid) {
                //登录失败
                $ret['code'] = 1;
                $ret['msg'] = sprintf("errcode: %d, errmsg:%s ", $xcxInfoAry['errcode'],$xcxInfoAry['errmsg']);
            } else {
                //登录成功
                $session_key = isset($xcxInfo['session_key'])?$xcxInfo['session_key']:'';
                $ret['data'] = [
                        'openid'=>$openid,
                        'session_key'=>$session_key,
                        'unionid'=>isset($xcxInfo['unionid'])?$xcxInfo['unionid']:'',
                ];
            }

        } else {
            //登录失败
            $ret['code'] = 1;
        }
        if(!$ret['code']) {
            return $this->responseSuccess($ret['data'], __METHOD__);
        } else {
            return $this->responseError($ret['code'], $ret['msg'], null, __METHOD__);
        }

    }

}