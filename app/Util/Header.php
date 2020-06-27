<?php
/**
 * 获取请求头工具类
 */
namespace App\Util;

class Header
{
    const APP_TYPE = 'APP_TYPE';//app类型 xiaoxiao:小小商城
    const APP_PLATFORM = 'APP_PLATFORM';//平台 i-iOS  a-Android mp-小程序 h5-H5站点 pc-PC站点 m-manage s-商家后台 order-订单 script-脚本
    const APP_V = 'APP_V';//版本号 1.0.0
    const APP_CHANNEL = 'APP_CHANNEL';//渠道编号 app_store：iOS渠道 site：Android主站渠道 yingyongbao：Android渠道
    const APP_OS_VERSION = 'APP_OS_VERSION';//系统版本号 12.0
    const APP_DEVICE_MODEL = 'APP_DEVICE_MODEL';//设备型号 iPhone，iPad，小米，华为
    const APP_DEVICE_ID = 'APP_DEVICE_ID';//设备号 设备唯一ID iOS使用openudid Android
    const APP_IDFV = 'APP_IDFV';//供应商标识符（iOS端）
    const APP_IDFA = 'APP_IDFA';//广告标识符（iOS端）
    const SHARE_ID = 'SHARE_ID';//分享ID
    const TOKEN = 'TOKEN';//登录态

    public static function getVal($key,$http_prefix = 'HTTP_'){
        $key = strtoupper($http_prefix.$key);
        return isset($_SERVER[$key])?$_SERVER[$key]:'';
    }

    /**
     * 强制指定固定key值
     */
    public static function setVal($key,$value,$http_prefix = 'HTTP_'){
        if(empty($key)){
            return false;
        }
        $key = strtoupper($http_prefix.$key);
        $_SERVER[$key] = $value;
        return true;
    }

    /**
     * 设备号 设备唯一ID
     * @return bool|string
     */
    public static function getDeviceId(){
        return self::getVal(self::APP_DEVICE_ID);
    }

    public static function getAppPlatform()
    {
        return self::getVal(self::APP_PLATFORM);
    }

    public static function getAppType(){
        return self::getVal(self::APP_TYPE);
    }

    public static function GetHeaderParams()
    {
        $params = [
            'ip'           => getClientIP(),
            'app_type'     => self::getAppType(),
            'app_platform' => self::getAppPlatform(),
            'app_version'  => self::getVal(self::APP_V),
            'api_version'  => 'v1',
            'phone_model'  => self::getVal(self::APP_DEVICE_MODEL),
            'cookie_guid'  => '',
        ];
        return $params;
    }

    /**
     * 获取各场景下的分享ID
     */
    public static function getShareId()
    {
        // 优先级：header > get/post
        $shareId = self::getVal(self::SHARE_ID);
        if (empty($shareId)) {
            $response = request()->getJson();
            $shareId = array_get($response, 'share_id', 0);
        }
        if (is_numeric($shareId)) {
            if (!is_int($shareId)) {
                $shareId = (int)$shareId;
            }
        } else {
            $shareId = 0;
        }
        return $shareId;
    }

    /**
     * 获取请求头token
     * @return string
     */
    public static function getToken(){
        return self::getVal(self::TOKEN);
    }
}