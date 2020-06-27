<?php
/**
 * Created by PhpStorm.
 * User: jelly
 * Date: 16/9/18
 * Time: 下午3:23
 */
require __DIR__ . '/common.php';
$wxConfig = include __DIR__ . '/config/WxH5.php';
$wxLoginObj = \CjsLogin\Weixin\WxWeb::create()->setWxConfig($wxConfig);
$tokenData = $wxLoginObj->getWebAccessToken();
var_export($tokenData);
