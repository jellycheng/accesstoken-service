<?php
/**
 * Created by PhpStorm.
 * 获取访问令牌
 * Date: 2020/6/24
 * Time: 22:11
 */
require_once __DIR__ . '/common.php';

$appid = isset($_SERVER['argv'][1])?$_SERVER['argv'][1]:'';
$secret = isset($_SERVER['argv'][2])?$_SERVER['argv'][2]:'';
if(!$appid) {
    exit("请输入appid，命令格式：php wxxcx_accesstoken.php appid secret" . PHP_EOL);
}

if(!$secret) {
    exit("请输入secret，命令格式：php wxxcx_accesstoken.php appid secret" . PHP_EOL);
}

$ret = \CjsLogin\Xcx\AccessToken::get($appid, $secret);
var_export($ret);
echo PHP_EOL;
