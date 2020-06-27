<?php
/**
 * 配置文件
 * 版本：3.3
 * 日期：2012-07-19
 */
 return array(
 	//合作身份者id，以2088开头的16位纯数字
	'partner'		=> '',
	//安全检验码，以数字和字母组成的32位字符
	'key'			=> '',
	//签名方式 strtoupper('MD5')， strtoupper('RSA')
	'sign_type'    => strtoupper('MD5'),

	//字符编码格式 目前支持 gbk 或 utf-8
	'input_charset'=> strtolower('utf-8'),

	//ca证书路径地址，用于curl中ssl校验
	//请保证cacert.pem文件在当前文件夹目录中  getcwd().'\\cacert.pem'
	'cacert'    => __DIR__.'/cacert.pem',

	//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
	'transport'    => 'http',

 );

?>