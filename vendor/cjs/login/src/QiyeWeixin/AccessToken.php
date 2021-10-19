<?php
/**
 * 企业微信访问令牌
 */
namespace CjsLogin\QiyeWeixin;

class AccessToken
{

    /**
     * 获取企业微信访问令牌
     * 文档：https://work.weixin.qq.com/api/doc/10013#第三步：获取access_token
     * 正常返回：{"errcode":0,"errmsg":"ok","access_token":"ACCESS_TOKEN","expires_in":7200}
     * 错误返回：{"errcode":40091,"errmsg":"secret is invalid"}
     */
    public static function get($corpid, $corpsecret) {
        $url = sprintf("https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=%s&corpsecret=%s",
                        $corpid,
                        $corpsecret
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