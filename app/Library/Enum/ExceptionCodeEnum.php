<?php
/**
 * 定义第三方错误代码
 */
namespace App\Library\Enum;

class ExceptionCodeEnum extends Enum
{
    //响应给对接方(app、小程序等)code值汇总 0~10000
    const SUCCESS = 0;//成功返回代码
    const FAIL = 1;//操作错误代码 新增/编辑/删除等操作失败
    const INVALID_ARGUMENT = 2;//参数错误
    const DATA_EXIST = 3;//数据已存在 用户/地址等数据存在
    const DATA_NOT_EXIST = 4;//数据不存在 用户/地址等数据不存在
    const USER_IS_LOCK = 5;//用户被锁定
    const REQUEST_TIMEDOUT = 28;//请求超时
    const SERVER_ERROR = 500;//服务错误
    /*用户相关错误code从8000~9000*/
    const USER_SR_NO_LOGIN = 8001;//SR用户不能登录状态
    const USER_TOKEN_EXPIRE = 8002;//登陆态过期
    const USER_ACCOUNT_FROZEN = 8004;//用户账号被冻结
    const USER_NO_LOGIN = 10000;//登陆态token过期/未登录 与ExceptionCode一致
    const SIGN_ERROR = 102;//签名错误
    #商品相关 9000~10000
    const GOODS_OUT_QTY = 9000;//超出可售库存
    const GOODS_OUT_RANGE = 9001;//超出配送范围
    const GOODS_LISTING_NO = 9002;//商品已下架
    const GOODS_RESTRICTION_QTY = 9003;//超出活动限购

    //用于内部打印log日志的常量错误代号
    const HANDEL_FAIL = 9999999;//操作失败 适用于 接口返回true/false接口 false时异常
    const USER_NOT_FOUND = 10000001;//用户不存在
    const USER_LOGIN_IS_LOCK = 10000016;//登录状态被锁定
    const SIGNATURE_AUTH_FAILED = 10000004;//签名验证失败
    const THIRD_ACCOUNT_BIND_USER_DONE = 10000007;//签名验证失败
    const PHONE_BINDING_OTHER_USER = 10002004;//手机号已绑定其他用户
    //下单支付
    const PREPARE_PAY_ORDER_STATUS_ERROR = 900009001;
    const PREPARE_PAY_ORDER_PAYTIME_ERROR = 900009003;
    const ORDERBACK_UPDATE_ORDER_ERROR = 900009002;
    const PREPARE_PAY_ORDER_FAIL_ERROR = 999999999;//申请支付授权失败
    const ORDER_PAY_DISABLED = 40000001;            // 支付功能维护中
    const ORDER_COMMIT_DISABLED = 50000001;         // 下单功能维护中
    //充值
    const USER_RECHARGE_DISABLED = 80000001;   //充值功能维护中
    const USER_RECHARGE_LEVEL_NOT_QUALIFIED = 80000002;   //充值功能只限代理身份
}