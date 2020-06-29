<?php
namespace App\Controllers;

use App\Modules\AccessTokenModule;

class AccessTokenController extends Base {

    //获取小程序的访问令牌
    public function getXcxAction()
    {
        $appid = isset($_GET['appid'])?$_GET['appid']:'';
        $secret = isset($_GET['secret'])?$_GET['secret']:'';
        if(!$appid) {
            return $this->responseError(1, "缺少appid参数");
        } 
        
        $ret = AccessTokenModule::getXcxAccessToken4redis($appid, $secret);
        if(!$ret['code']) {
            return $this->responseSuccess($ret['data'], __METHOD__);
        } else {
            return $this->responseError($ret['code'], $ret['msg'], null, __METHOD__);
        }
        
    }

    //清除小程序访问令牌
    public function clearXcxAction() {
        $appid = isset($_GET['appid'])?$_GET['appid']:'';
        if(!$appid) {
            return $this->responseError(1, "缺少appid参数");
        } 
        
        $ret = AccessTokenModule::clearXcxAccessToken4redis($appid);
        return $this->responseSuccess([], __METHOD__);
    }

}