<?php
/**
 * 微信小程序-解密手机号
 *  http://127.0.0.1:9988/wxxcx_phone.php?appid=wx94bcdb7377bb2c39&code=
 * 小程序获取手机号文档：
 *  https://developers.weixin.qq.com/miniprogram/dev/framework/open-ability/getPhoneNumber.html
 *
 * 第1步： 用户登录，示例见：wxxcx_login.php
 * 第2步：在小程序用户点击 <button open-type="getPhoneNumber" bindgetphonenumber="getPhoneNumber">绑定手机号</button>
 *       js代码： Page({ getPhoneNumber:function(res){ console.log(res.detail); 这里把res.detail值给服务器 } });
 *
 */
require __DIR__ . '/common.php';

$appid = isset($_GET['appid'])?$_GET['appid']:'wx94bcdb7377bb2c39';
//这是上次通过\CjsLogin\Xcx\WeixinXcx::jscode2session($cxcParam)方法中返回的session_key值，示例见：wxxcx_login.php
$sessionKey = '1yxsGfOKQroafwXvYPC+sA==';

//小程序传上来的参数值
$encryptedData = "GczFAu/QnVv5ak2RQMbLk4FgRrwr4/cY7zabEx4rGLShrkkf+3d9HaUaLX/HXgm9ynLeSG1VFmvxPNyFSoV/NElJovxlMIPapN+tWLxQQ9nrVrSCKUFMuxBADNdoWP6vGiIqo1fG8JPBQfL2dtCJKblJ5LafnyEx/k+JnQMUAfZbZfhlH4UKFgOnmjigeRK0qnzcHkyThcdT776b2xv22A==";
//小程序传上来的参数值
$iv = 'YcXJ7g3M41bQI1c5gdPG7A==';

$pc = new \CjsLogin\Xcx\Weixin\WXBizDataCrypt($appid, $sessionKey);
$errCode = $pc->decryptData($encryptedData, $iv, $data );

if ($errCode == 0) {//解密成功
    print($data . "\n");
    /** 解析出来的内容如下：
     {
        "phoneNumber": "13712345678", //用户绑定的手机号（国外手机号会有区号）
        "purePhoneNumber": "13712345678", //没有区号的手机号
        "countryCode": "86",   //手机区号
        "watermark": {
            "timestamp": 1553757398,  //时间戳，用户在小程序中点击时的时间
            "appid": "wx94bcdb7377bb2c39"   //开发者可校验此参数与自身 appId 是否一致
            }
        }
     */
    $res = json_decode($data, true);
    echo "手机号：" . $res['purePhoneNumber'] . PHP_EOL;
} else {
    print($errCode . "\n");
}


