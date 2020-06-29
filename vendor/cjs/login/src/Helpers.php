<?php
namespace CjsLogin;
/**
 * 助手函数
 */

function randStr($length = 16){
    // 密码字符集，可任意添加你需要的字符
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $str = "";
    for($i = 0; $i < $length; $i++)
    {
        $str .= $chars[mt_rand(0, strlen($chars) - 1)];
    }
    return $str;
}

/**
 * 支付宝代码目录
 * @return string
 */
function getZfbPath() {
    return __DIR__ . '/Zfb/';
}

/**
 * QQ代码目录
 * @return string
 */
function getQQPath() {
    return __DIR__ . '/QQ/';
}


/**
 * 微信代码目录
 * @return string
 */
function getWeixinPath() {
    return __DIR__ . '/Weixin/';
}

/**
 * 小程序代码目录：微信、支付宝、百度、qq等小程序
 * @return string
 */
function getXcxPath($subPath = '') {
    return __DIR__ . '/Xcx/' . $subPath;
}

