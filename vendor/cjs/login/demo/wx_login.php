<?php
/**
 * Created by PhpStorm.
 * User: jelly
 * Date: 16/9/18
 * Time: 下午3:23
 */
require __DIR__ . '/common.php';
$wxConfig = include __DIR__ . '/config/WxH5.php';
$redirectUrl = $wxConfig['login_callback_url'];
$url = \CjsLogin\Weixin\WxWeb::create()->setWxConfig($wxConfig)->getOauth2Url($redirectUrl, 'snsapi_userinfo');
header("Location: " . $url);

