<?php
namespace CjsLogin\Weixin;

/**
 * 用于h5网站使用微信登录
 * 微信网页授权是通过OAuth2.0机制实现的
 * 1 第一步：用户同意授权，获取code(code是微信自动带到跳转地址上的code参数?code=&state=)
    2 第二步：通过code换取网页授权access_token
    3 第三步：刷新access_token（如果需要）
    4 第四步：拉取用户信息(需scope为 snsapi_userinfo)
    5 附：检验授权凭证（access_token）是否有效
 */
class WxWeb extends WxBase {


    /**
     * 第一步
     * @param $appid
     * @param $redirect_uri
     * @param string $scope
     * @param null $state
     */
    public function getOauth2Url($redirect_uri, $scope='snsapi_userinfo', $state=null, $appid=null) {
        if(!$scope) {
            $scope = 'snsapi_userinfo'; //snsapi_base
        }
        if(!$state) {
            $state = \CjsLogin\randStr(4);
        }
        $appid = $appid?:$this->getWxConfig('appid');
        $url = sprintf('https://open.weixin.qq.com/connect/oauth2/authorize?appid=%s&redirect_uri=%s&response_type=code&scope=%s&state=%s#wechat_redirect',
                        $appid, urlencode($redirect_uri),$scope,$state
                    );
        return $url;

    }

    /**
     * 扫描二维码登录 -开放平台接口 https://open.weixin.qq.com/
     * @param $redirect_uri
     * @param string $scope
     * @param null $state
     * @param null $appid
     * @return string
     */
    public function getQrconnect($redirect_uri, $scope='snsapi_login', $state=null, $appid=null) {
        if(!$scope) {
            $scope = 'snsapi_login';
        }
        if(!$state) {
            $state = \CjsLogin\randStr(4);
        }
        $appid = $appid?:$this->getWxConfig('appid');
        $url = sprintf('https://open.weixin.qq.com/connect/qrconnect?appid=%s&redirect_uri=%s&response_type=code&scope=%s&state=%s#wechat_redirect',
            $appid, urlencode($redirect_uri),$scope,$state
        );
        return $url;
    }

    /**
     * 第二步: 通过code换取网页授权access_token
     * @param $code
     * @param null $appid
     * @param null $secret
     * @return
     * { "access_token":"ACCESS_TOKEN访问令牌",
        "expires_in":7200有效期,
        "refresh_token":"REFRESH_TOKEN用于刷新令牌的",
        "openid":"OPENID",
        "scope":"SCOPE"
     * }
     */
    public function getWebAccessToken($code='',$appid=null,$secret=null) {
        $resData = [];
        if(!$code) {
            $code = isset($_GET['code'])?$_GET['code']:'';
        }
        $appid = $appid?:$this->getWxConfig('appid');
        $secret = $secret?:$this->getWxConfig('appsecret');
        $url = sprintf('https://api.weixin.qq.com/sns/oauth2/access_token?appid=%s&secret=%s&code=%s&grant_type=authorization_code',
                $appid,$secret,$code
            );
        $content = file_get_contents($url);

        if($tmp = $this->jsonDecode($content)){
            if(isset($tmp['errcode']) && $tmp['errcode']) {
                //微信出错了
                $this->setErr($tmp['errcode'], $tmp['errmsg']);
            } else {
                $resData = $tmp;
            }

        }
        return $resData;
    }

    /**
     * 通过刷新令牌更新令牌有效期
     * @param $refresh_token
     * @param null $appid
     * @return array
     */
    public function refreshToken($refresh_token, $appid=null) {
        $resData = [];
        $appid = $appid?:$this->getWxConfig('appid');
        $url = sprintf('https://api.weixin.qq.com/sns/oauth2/refresh_token?appid=%s&grant_type=refresh_token&refresh_token=%s',
                    $appid, $refresh_token
                );
        $content = file_get_contents($url);

        if($tmp = $this->jsonDecode($content)){
            if(isset($tmp['errcode']) && $tmp['errcode']) {
                //微信出错了
                $this->setErr($tmp['errcode'], $tmp['errmsg']);
            } else {
                $resData = $tmp;
            }

        }
        return $resData;

    }

    /**
     * 获取用户基本信息
     * @param $access_token
     * @param $openid
     * @param string $lang
     * @return array|mixed
     * {    "openid":" OPENID",
            " nickname": 昵称,
            "sex":"1", 性别,1男2女
            "province":"用户个人资料填写的省份"
            "city":"普通用户个人资料填写的城市",
            "country":"国家，如中国为CN",
            "headimgurl":"头像",
            "privilege":[ "用户特权信息" "PRIVILEGE2"     ],
            "unionid": "o6_bmasdasdsad6_2sgVt7hMZOPfL"
     * }
     */
    public function getUserInfo($access_token, $openid, $lang='zh_CN') {
        $resData = [];
        $url = sprintf('https://api.weixin.qq.com/sns/userinfo?access_token=%s&openid=%s&lang=%s',
                        $access_token, $openid, $lang
                      );
        $content = file_get_contents($url);

        if($tmp = $this->jsonDecode($content)){
            if(isset($tmp['errcode']) && $tmp['errcode']) {
                //微信出错了
                $this->setErr($tmp['errcode'], $tmp['errmsg']);
            } else {
                $resData = $tmp;
            }

        }
        return $resData;
    }

    /**
     * 检验授权凭证（access_token）是否有效
     * @param $access_token
     * @param $openid
     * @return bool
     */
    public function checkAccessToken($access_token, $openid)
    {
        $bool = false;
        $url = sprintf('https://api.weixin.qq.com/sns/auth?access_token=%s&openid=%s',
                $access_token,$openid
                );
        $content = file_get_contents($url);
        if($tmp = $this->jsonDecode($content)){
            if(isset($tmp['errcode']) && $tmp['errcode']==0) {
                $bool = true;
            } else {//微信出错了
                $this->setErr($tmp['errcode'], $tmp['errmsg']);
            }

        }
        return $bool;

    }


}