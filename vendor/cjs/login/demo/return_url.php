<?php
/* * 
 * 功能：支付宝页面跳转同步通知页面  client-client
 * 版本：3.3
 * 日期：2012-07-23
 */
require __DIR__ . 'common.php';
$zfbConfig = include \CjsLogin\getZfbPath() . '/Config/alipay.config.php';
$zfbConfig = array_merge($zfbConfig, include __DIR__ . '/zfb_login.config.php');

#return_url.php?is_success=T&notify_id=RqPnCoPT3K9%252Fvwbh3InXQBocqFx%252Fn4edMaLrO30VZmtho4iCmSPVo9oBYD%252BAQ7q1ZmH0&token=2016072705c9a073abcb4beb808fd19b90906X73&user_id=2088121461512731&sign=1630c34afe48a298a4919933f9ad7b90&sign_type=MD5
?>
<!DOCTYPE HTML>
<html>
    <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>支付宝快捷登录接口</title>
	</head>
    <body>
<?php
//计算得出通知验证结果
$alipayNotify = new \CjsLogin\Zfb\AlipayNotify($zfbConfig);
$verify_result = $alipayNotify->verifyReturn();
if($verify_result) {//验证成功
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//请在这里加上商户的业务逻辑程序代码
	
	//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
    //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表

	//支付宝用户号

	$user_id = $_GET['user_id'];

	//授权令牌
	$token = $_GET['token'];


	//判断是否在商户网站中已经做过了这次通知返回的处理
		//如果没有做过处理，那么执行商户的业务程序
		//如果有做过处理，那么不执行商户的业务程序
		
	echo "验证成功<br />user_id: " . $user_id . ', token: ' . $token;

	//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
} else {
    //验证失败

    echo "验证失败";
}
?>


    </body>
</html>