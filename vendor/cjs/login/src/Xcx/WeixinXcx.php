<?php
namespace CjsLogin\Xcx;
/**
 * 微信小程序类
 */
class WeixinXcx {

    /**
     * 通过code获取openid、unionid
     * 登录小程序登录，文档：https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/login/auth.code2Session.html
     * 业务流程：小程序调用wx.login()接口成功之后，获取到的code传给服务器，服务器去微信服务验证是否正确，正确返回用户openid、session_key、unionid等信息
     * 响应格式：
     *   错误格式 {"errcode":40013,"errmsg":"invalid appid, hints: [ req_id: VD07552165 ]"}
     *   正确格式：{"session_key":"6jCWiqlQOtjZ95yPlt85cw==","openid":"oV0Kl5COyKGH_itTIXtsFGx3lV04","unionid":"用户在开放平台的唯一标识符，在满足UnionID下发条件的情况下会返回,否则没这个key"}
     *          其中openid为用户唯一标识，session_key为会话密钥
     */
    public static function jscode2session($param = []) {

        $appid = isset($param['appid'])?$param['appid']:'';//小程序平台分配的 appid
        $appsecret = isset($param['appsecret'])?$param['appsecret']:'';//小程序平台分配的 app secret
        $code = isset($param['code'])?$param['code']:'';//登录时获取的 code,一个code只能验证一次

        $url = sprintf("https://api.weixin.qq.com/sns/jscode2session?appid=%s&secret=%s&js_code=%s&grant_type=authorization_code",
                       $appid,$appsecret,$code
                     );
        $streamParam = [
            "ssl"=>[
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ]
        ];
        $content = file_get_contents($url, false, stream_context_create($streamParam));
        return $content;
    }

}
