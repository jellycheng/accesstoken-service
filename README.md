# accesstoken-service
```
访问令牌服务: 适应于微信公众号、微信小程序、企业微信
解决线上环境（生产环境prod）、线下环境（dev、st、pre等）使用同一个appid进行对接、研发、联调、测试、上线
不用申请多个商户号，降低企业的费用，及人员维护成本

```

## 接口协议
```
1。获取微信公众号或小程序访问令牌接口：
    http://qsh.5ecms.com/AccessToken/getXcx?appid=公众号或小程序的appid&secret=密钥
    或者
    http://qsh.5ecms.com/AccessToken/getXcx?appid=公众号或小程序的appid
        备注： 如果.env中有配置appid对应的密钥，则secret参数可以不传，自动取env中配置的

    成功响应示例：
    {
        "code": 0,
        "msg": "success",
        "data": {
            "access_token": "访问令牌",
            "expires_in": 7190
        },
        "trace_id": "5958c360-518a-11eb-81d2-0bfcec717f4a"
    }
2。清除微信公众号或小程序访问令牌cache
    http://qsh.5ecms.com/AccessToken/clearXcx?appid=公众号或小程序的appid
    成功响应示例：
    {
        "code": 0,
        "msg": "success",
        "data": {},
        "trace_id": "adde6950-518a-11eb-a84c-1d1feb2ba704"
    }
    
3. 获取企业微信访问令牌
    http://qsh.5ecms.com/AccessToken/getQyapi?corpid=企业id&secret=应用密钥
    备注： 一个企业ID可对应多个应用密钥

    成功响应示例：
    {
        "code": 0,
        "msg": "success",
        "data": {
            "access_token": "访问令牌",
            "expires_in": 7190
        },
        "trace_id": "db73ba00-30c4-11ec-ae94-e77c915ae442"
    }

4. 清除企业微信访问令牌
    http://qsh.5ecms.com/AccessToken/clearQyapi?corpid=企业id&secret=应用密钥
    响应成功：
    {
        "code": 0,
        "msg": "success",
        "data": {},
        "trace_id": "53a40870-30c5-11ec-b1ce-01b935f36bc3"
    }

发生错误响应的格式示例（code值不为0则表发生错误）：
{
    "code": 1,
    "msg": "缺少corpid参数",
    "data": {},
    "trace_id": "6d576ef0-30c5-11ec-a5ac-c73202f0bdf3"
}
 
```

## 资料
```
微信访问令牌（即调用凭证）：
    https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/access-token/auth.getAccessToken.html

企业微信获取访问令牌：
    https://work.weixin.qq.com/api/doc/10013#第三步：获取access_token

```
