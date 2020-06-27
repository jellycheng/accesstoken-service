<?php
/**
 * 这个文件是无命名空间的助手函数
 * 添加此类函数注意影响面
 */
use Carbon\Carbon;
use App\Util\Request;

if (!function_exists('env')) {
    /**
     * Gets the value of an environment variable. Supports boolean, empty and null.
     *
     * @author chengjinsheng
     * @param  string $key
     * @param  mixed $default
     * @return mixed
     */
    function env($key, $default = null)
    {
        $value = getenv($key);
        if ($value === false) {
            return value($default);
        }
        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;
            case 'false':
            case '(false)':
                return false;
            case 'null':
            case '(null)':
                return null;
            case 'empty':
            case '(empty)':
                return '';
        }
        return $value;
    }
}

if (!function_exists('value')) {
    /**
     * Return the default value of the given value.
     *
     * @author chengjinsheng
     * @param  mixed $value
     * @return mixed
     */
    function value($value)
    {
        return $value instanceof Closure ? $value() : $value;
    }
}

if (!function_exists('with')) {
    /**
     * Return the given object. Useful for chaining.
     *
     * @author chengjinsheng
     * @param  mixed $object
     * @return mixed
     */
    function with($object)
    {
        return $object;
    }
}

if (!function_exists('isNumericInArray')) {
    /**
     * 校验一维数组中值是否均为Numeric类型
     *
     * @author chengjinsheng
     * @param array $arr
     * @return bool
     */
    function isNumericInArray($arr)
    {
        if ( !is_array($arr) || empty($arr)) {
            return false;
        }
        foreach ($arr as $v) {
            if ( !is_numeric($v)) {
                return false;
            }
        }
        return true;
    }
}

/**
 * 将二维数组的值提取为键
 *
 * @author chengjinsheng
 * @date 2016-10-11
 * @param array $arr 二维数组
 * @param string $str 要作为键的值
 * @return array
 */
 function getKeyChange($arr, $str)
{
    $data = [];
    foreach ($arr as $v) {
        $data[$v[$str]] = $v;
    }
    return $data;
}

/**
 * 将二维数组的值提取为键
 *
 * @author chengjinsheng
 * @date 2017-09-06
 * @param array $arr 二维数组
 * @param string $str 要作为键的值
 * @return array
 */
function getFieldAsKey($arr, $field)
{
    $keys = array_column($arr,$field);
    $aData = array_combine($keys,$arr);

    return $aData;
}

/*
 * 获取指定日期的开始和结束时间戳 默认yesterday
 */
function getStartEndOfDate($sDate = null)
{
    $dt = $sDate ? Carbon::parse($sDate) : Carbon::yesterday();
    $startOfDate = $dt->startOfDay()->timestamp;
    $endOfDate = $dt->endOfDay()->timestamp;

    return [
        'startOfDate' => $startOfDate, 'endOfDate' => $endOfDate,
    ];
}

/**
 * 获取指定日期段内每一天的日期
 *
 * @param $sStartDate
 * @param $sEndDate
 *
 * @return array
 *
 * @author  chengjinsheng
 * @version 1.0
 */
function getDateRange($sStartDate, $sEndDate) {
    $stime = strtotime($sStartDate);
    $etime = strtotime($sEndDate);
    $aDateArr = [];
    while ($stime <= $etime) {
        $aDateArr[] = date('Y-m-d', $stime);
        $stime += 86400;
    }
    return $aDateArr;
}

//获取业务模块名
function getModuleName() {
    $moduleName = getenv('MODULE_NAME');
    if(!$moduleName) {
        $moduleName = isset($_GET['module_name'])?ucfirst($_GET['module_name']):'Mobile';
    }
    if(!$moduleName || !preg_match('/^[a-z0-9_-]+$/i', $moduleName)){
        $moduleName = 'Mobile';
    }
    if(strtolower($moduleName) == 'api') {
        $moduleName = 'Mobile';
    }
    return ucfirst($moduleName);
}

if (!function_exists('request')) {
    /**
     * 获取当前Request对象实例
     * @return Request
     */
    function request()
    {
        return Request::instance();
    }
}

/**
 * 获取客户端IP
 * @return string
 */
function getClientIP() {
    $ip = '';
    if(isset($_SERVER['HTTP_REALIP']) && $_SERVER['HTTP_REALIP']) {
        $ip = $_SERVER['HTTP_REALIP'];
    } else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR']) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else if(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR']) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    if (empty($ip)) {
        $ip = '0.0.0.0';
    }
    return $ip;
}

if (! function_exists('mydd')) {
    /**
     * Dump the passed variables and end the script.
     *
     * @param  mixed  $args
     * @return void
     */
    function mydd(...$args)
    {
        foreach ($args as $x) {
            (new \Illuminate\Support\Debug\Dumper)->dump($x);
        }

        die(1);
    }
}

// 取多维数组值
if(!function_exists('array_column_deep')){
    function array_column_deep(array &$rows, $column_key, $index_key = null){
        $data = [];
        if (empty($index_key)) {
            foreach ($rows as $row) {
                $data[] = array_get($row,$column_key,'');
            }
        } else {
            foreach ($rows as $row) {
                $data[$row[$index_key]] = array_get($row,$column_key,'');
            }
        }
        return $data;
    }
}