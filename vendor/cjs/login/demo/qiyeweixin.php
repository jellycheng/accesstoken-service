<?php
require __DIR__ . '/common.php';

$corpid = "ww0ca05641227fc2e0"; // 企业ID，企业微信后台查看位置：我的企业-》企业信息-》企业ID
$corpsecret = "xxx"; // 某个应用的密钥
$res = \CjsLogin\QiyeWeixin\AccessToken::get($corpid, $corpsecret);
var_export($res);
echo PHP_EOL;
