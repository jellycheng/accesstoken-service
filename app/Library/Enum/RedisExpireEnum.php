<?php
/**
 * redis 有效时间配置 单位是秒
 */
namespace App\Library\Enum;

class RedisExpireEnum extends Enum
{
    const EXPIRE_SECOND_ONE = 1;//1秒
    const EXPIRE_SECOND_TEN = 10;//10秒
    const EXPIRE_SECOND_THIRTY = 30;//30秒

    const EXPIRE_MINUTE_ONE = 60;//1分钟
    const EXPIRE_MINUTE_FIVE = 300;//5分钟
    const EXPIRE_MINUTE_TEN = 600;//10分钟
    const EXPIRE_MINUTE_THIRTY = 1800;//30分钟

    const EXPIRE_HOUR_ONE = 3600;//1小时
    const EXPIRE_HOUR_TWO = 7200;//2小时
    const EXPIRE_HOUR_THEE = 10800;//3小时
    const EXPIRE_HOUR_TEN = 36000;//10小时
    
    
    const EXPIRE_DAY_ONE = 86400;//1天
}