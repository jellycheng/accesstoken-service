<?php
//https://mp.weixin.qq.com/wiki
/**
1. 通用域名(api.weixin.qq.com)，使用该域名将访问官方指定就近的接入点；
2. 上海域名(sh.api.weixin.qq.com)，使用该域名将访问上海的接入点；
3. 深圳域名(sz.api.weixin.qq.com)，使用该域名将访问深圳的接入点；
4. 香港域名(hk.api.weixin.qq.com)，使用该域名将访问香港的接入点。
 */
return [
    'appid'=>'wx372fb2537470d443',
    'appsecret'=>'d4624c36b6795d1d99dcf0547af5443d',
    'token'=>'testtoken8',
//    'encodingaeskey'=>'',
//    'encoding_type'=>1,//消息加解密方式 1.明文模式 2. 兼容模式 3.安全模式
//    'wx_api_domain'=>'https://api.weixin.qq.com/', //一定要带 /
//    'access_token_save_handle'=>'file', //file, redis, mysql,或写具体的类名
//    'access_token_ini'=>[//传给访问令牌保存的参数
//        'filename'=>__DIR__ . '/access_token.json'
//    ],
    'login_callback_url'=>'http://domain/login/wxcallback', //微信登录回调地址
];