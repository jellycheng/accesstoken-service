<?php namespace App\Controllers;

use App\Controllers\Base;
use App\Library\Exceptions\ServiceException;
use App\Modules\JsSDKModule;
use App\Util\ValidatorUtil;

class JsSDKController extends Base
{

    /**
     * 获取微信JsSDK的JsApi Signature
     */
    public function getJsApiSignAction()
    {
        $rulesMap = [
//            'service_name' => ['required|string', '服务名'],
//            'app_env'      => ['required|string', '环境名'],
            'wx_app_id'    => ['required|string', '微信AppID'],
            'wx_app_secret'=> ['string', '微信appsecret'],
            'url'          => ['required|string', '当前页面的完整URL'],
//            'timestamp'    => ['required|numeric', '时间戳'],
//            'sign'         => ['required|string', '签名'],
        ];
        list($rules, $message) = ValidatorUtil::formatRule($rulesMap);
        try {
            $data = $this->validate(request()->getJson(), $rules, $message, true);
            $ret  = JsSDKModule::getJsApiSign($data);
            return $this->responseSuccess($ret);
        } catch (ServiceException $e) {
            //$this->log(__METHOD__, $e->getCode(), $e->getMessage());
            return $this->responseError($e->getCode(), $e->getMessage());
        }
    }
}