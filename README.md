# accesstoken-service
```
访问令牌服务
解决线上环境（生产环境prod）、线下环境（dev、st、pre等）使用同一个appid进行对接、研发、联调、测试、上线
不用申请多个商户号，降低企业的费用，及人员维护成本

```

## 接口协议
```
1。获取访问令牌格式：
    http://qsh.5ecms.com/AccessToken/getXcx?appid=公众号或小程序的appid&secret=密钥
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
2。清除访问令牌cache
    http://qsh.5ecms.com/AccessToken/clearXcx?appid=公众号或小程序的appid
    成功响应示例：
    {
        "code": 0,
        "msg": "success",
        "data": {},
        "trace_id": "adde6950-518a-11eb-a84c-1d1feb2ba704"
    }
    
```
