<?php
/**
 * 微信小程序登录
 *  http://127.0.0.1:9988/wxxcx_login.php?appid=wx94bcdb7377bb2c39&code=
 * 小程序对接登录文档：https://developers.weixin.qq.com/miniprogram/dev/framework/open-ability/login.html
 *
 */
require __DIR__ . '/common.php';
$wxConfig = include __DIR__ . '/config/weixinxcx.php';

$appid = isset($_GET['appid'])?$_GET['appid']:'';
$appsecret = isset($wxConfig[$appid])?$wxConfig[$appid]['appsecret']:'';
$code = isset($_GET['code'])?$_GET['code']:'';
$cxcParam = [
                'appid'=>$appid,     //小程序的 app id
                'appsecret'=>$appsecret,//小程序的 app secret
                'code'=>$code,  //登录时获取的 code,一个code只能验证一次
            ];
$xcxInfo = \CjsLogin\Xcx\WeixinXcx::jscode2session($cxcParam);
if($xcxInfo) {
	$xcxInfoAry = json_decode($xcxInfo, true);
	echo "weixin server response content: " . var_export($xcxInfoAry, true);
	$openid = isset($xcxInfoAry['openid'])?$xcxInfoAry['openid']:"";
	if(!$openid) {
		//登录失败
        echo 'fail' . PHP_EOL;
        exit;
	}
	//登录成功

	$session_key = isset($xcxInfo['session_key'])?$xcxInfo['session_key']:'';
	echo $session_key . PHP_EOL;
} else {
	//登录失败
}


