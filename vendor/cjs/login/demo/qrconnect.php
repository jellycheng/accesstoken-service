<?php
/**
 * http://127.0.0.1:9988/qrconnect.php
 *
 * pc网页对接微信扫码登录：前提必须是在开放平台的网站应用
 * 开放平台： https://open.weixin.qq.com/
 * 1. 扫描页面：https://open.weixin.qq.com/connect/qrconnect?appid=&redirect_uri=&response_type=code&scope=snsapi_login&state=state#wechat_redirect
 *    其中： appid是在微信开放平台中"管理中心"-》"网站应用"点击网站应用查看appid
 *          redirect_uri=登录成功回调地址，且微信回来会追加2个参数?code=微信产生&state=我方给的原样值
 *          response_type=code 固定写法
 *          scope=snsapi_login  固定写法
 *          state=接入方自定义的内容值，便于接入方防止csrf等攻击，扫描登录成功后，会原样把这个值带给回调地址
 *
 * 2. 通过code获取access_token
 *      https://api.weixin.qq.com/sns/oauth2/access_token?appid=开放平台分给应用的appid&secret=开放平台分给应用的秘钥&code=CODE&grant_type=authorization_code
 *      返回：{"access_token":"ACCESS_TOKEN","expires_in":7200,"refresh_token":"REFRESH_TOKEN","openid":"OPENID","scope":"SCOPE","unionid": "o6_bmasdasdsad6_2sgVt7hMZOPfL" }
 *
 *
 */

require __DIR__ . '/common.php';

$wxConfig = [
            'appid'=>'wx867db890183a7a90',

];
$wxWebObj = \CjsLogin\Weixin\WxWeb::create()->setWxConfig($wxConfig);
$redirectUrl = "http://www.nfangbian.com/wxlogin/index"; //回调地址
$goWxUrl = $wxWebObj->getQrconnect($redirectUrl);
header("Location: " . $goWxUrl);//跳转扫描页面

