<?php
/**
 * 访问令牌
 */

namespace CjsLogin\Xcx;


class AccessToken
{

    /**
     * 获取访问令牌
     * 文档：https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/access-token/auth.getAccessToken.html
     * 正常返回：{"access_token":"ACCESS_TOKEN","expires_in":7200}
     * 错误返回：{"errcode":40013,"errmsg":"invalid appid"}
     */
    public static function get($appid, $secret) {
        $url = sprintf("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=%s&secret=%s",
                        $appid,
                        $secret
                        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, $url);
        $ret =  curl_exec($ch);
        curl_close($ch);
        if($ret) {
            $ret = \json_decode($ret, true);
        }
        return $ret;

    }


}