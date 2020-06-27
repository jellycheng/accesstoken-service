<?php
/**
 * 支付宝登录
 * Created by PhpStorm.
 * User: jelly
 * Date: 16/7/25
 * Time: 下午2:16
 */
require __DIR__ . '/common.php';

$zfbConfig = include \CjsLogin\getZfbPath() . '/Config/alipay.config.php';
$zfbConfig = array_merge($zfbConfig, include __DIR__ . '/zfb_login.config.php');

     
//需http://格式的完整路径，不允许加?id=123这类自定义参数
//防钓鱼时间戳
$anti_phishing_key = "";
//若要使用请调用类文件submit中的query_timestamp函数
//客户端的IP地址
$exter_invoke_ip = "";
//非局域网的外网IP地址，如：221.0.0.1

//构造要请求的参数数组，无需改动
$parameter = array(
		"service" => "alipay.auth.authorize",  //登陆固定写法
		"partner" => trim($zfbConfig['partner']),
		"target_service"	=> $zfbConfig['target_service'], //目标服务地址
		"return_url"	=> $zfbConfig['return_url'],
		"anti_phishing_key"	=> $anti_phishing_key,
		"exter_invoke_ip"	=> $exter_invoke_ip,
		"_input_charset"	=> trim(strtolower($zfbConfig['input_charset']))
);

//建立请求
$alipaySubmit = new \CjsLogin\Zfb\AlipaySubmit($zfbConfig);
#方式1 通过js跳转
$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认登录");
echo $html_text;
exit;
#方式2 获取内容，自己来组装
$resData = $alipaySubmit->getBuildRequestForm($parameter,"get");
var_export($resData);
