<?php
/**
 * 微信小程序-解密用户信息
 *  http://127.0.0.1:9988/wxxcx_getuser.php?appid=wx94bcdb7377bb2c39&code=
 * 小程序获取用户文档：
 *  https://developers.weixin.qq.com/miniprogram/dev/api/wx.getUserInfo.html
 *
 * 第1步： 用户登录，示例见：wxxcx_login.php
 * 第2步：在小程序用户点击 <button open-type="getUserInfo" bindgetuserinfo="bindGetUserInfo" >获取用户信息</button>
 *       js代码： Page({ bindGetUserInfo:function(res){ console.log(res.detail); 这里把res.detail值给服务器 } });
 *
 */
require __DIR__ . '/common.php';

$appid = isset($_GET['appid'])?$_GET['appid']:'wx94bcdb7377bb2c39';
//这是上次通过\CjsLogin\Xcx\WeixinXcx::jscode2session($cxcParam)方法中返回的session_key值，示例见：wxxcx_login.php
$sessionKey = 'JKigfzDBRMTGlHLhIHLteg==';

//小程序传上来的参数值
$encryptedData = "FSaAOp/x+6nPOqwaW+Q/eps/2jYKH5H7hUQbMrxLIqV5PNUTrelBLzThiK3/mGo4kQF2Y6qkM/E4gjQ0gUHqMB/xBinMecSQBWLkbhVPu9IUUapIH4sAAE54Fu3xRsXfKuDA6SeeI/yujS18mTC8R8endTveHV+UVG6T+1B4JPAufde4AkyaPBFaCbzJodOYTimPfYaLh0ChdprVgn5AEVZO7iBemi8KXVxvOMcOEepG7ijsXpNEp4T/17BLh1VymwToJgk4UN4qoCkg2Aw4i9xKgsxND0Z51rUvBUsn/tTVRNXkgtEptVCwXYp7qd643xHXaVX8n6KxeAy8VivzFtxHxc5hzkCb8/uHEm8DumKMek+aHYlTNmDDmk1q8Awvls7nqHQoUoZQewhqrjdpi3mNekEd6VZRKj/dxoryMmDZGJ/4tBIYmUTOqQ9tPfiEuHgaDAW1KBb57Ic2VgMe+Poca60amgjQ1dkOujNEDDIrEZRfg5MByhODw684ATEU";
//小程序传上来的参数值
$iv = 'hCMF9qDPKV126uCD+BBTvA==';

$pc = new \CjsLogin\Xcx\Weixin\WXBizDataCrypt($appid, $sessionKey);
$errCode = $pc->decryptData($encryptedData, $iv, $data );

if ($errCode == 0) {//解密成功
    print($data . "\n");
    /** 解析出来的内容如下：每个字段含义见： https://developers.weixin.qq.com/miniprogram/dev/api/UserInfo.html
    {
        "openId": "oO9Rq0y9RZYZVUMShUHhx7ltX8ao", //用户唯一值
        "unionId": "UNIONID",  //用户在开放平台的用户ID，只有应用被绑定到开放平台才有这个值，值唯一
        "nickName": "张三",  //昵称
        "gender": 1,    //性别
        "language": "zh_CN", //语言
        "city": "Pudong New District", //城市
        "province": "Shanghai", //省份
        "country": "China", //国家
        "avatarUrl": "https://wx.qlogo.cn/mmopen/xx", //头像地址
        "watermark": {
            "timestamp": 1553759380, //时间戳，用户在小程序中点击时的时间
            "appid": "wx94bcdb7377bb2c39" //开发者可校验此参数与自身 appId 是否一致
         }
    }
     */
    $res = json_decode($data, true);
    echo "昵称：" . $res['nickName'] . PHP_EOL;
} else {
    print($errCode . "\n");
}


