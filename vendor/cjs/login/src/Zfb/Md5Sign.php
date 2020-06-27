<?php
namespace CjsLogin\Zfb;
/* *
 * MD5
 * 详细：MD5加密
 * 版本：3.3
 * 日期：2012-07-19
 * 说明：支付宝接口MD5函数文件
 */
class Md5Sign {

	/**
	 * \CjsLogin\Zfb\Md5Sign::md5Sign('str', 'key');
	 * 签名字符串
	 * @param $prestr 需要签名的字符串
	 * @param $key 私钥
	 * return 签名结果
	 */
	public static function md5Sign($prestr, $key) {
		$prestr = $prestr . $key;
		return md5($prestr);
	}

	/**
	 * \CjsLogin\Zfb\Md5Sign::md5Verify('str', 'sign', 'key');
	 * 验证签名
	 * @param $prestr 需要签名的字符串
	 * @param $sign 签名结果
	 * @param $key 私钥
	 * return 签名结果
	 */
	public static function md5Verify($prestr, $sign, $key) {
		$prestr = $prestr . $key;
		$mysgin = md5($prestr);

		if($mysgin == $sign) {
			return true;
		} else {
			return false;
		}
	}

}
?>