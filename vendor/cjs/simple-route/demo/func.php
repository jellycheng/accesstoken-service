<?php
/**
 * 分隔算法
 * User: jelly
 * Date: 2019/7/7
 * Time: 10:13
 */
//$url = $_SERVER['REQUEST_URI']; //取url地址

// /api/版本/服务名/目录1/目录N/方法名
$url1 = "/api/v1/user/wechat//xx/exitCustomerProfileUnionid?a=1&b=3#xyz";
var_export(parseUrlSplit($url1));
echo PHP_EOL . PHP_EOL;

$url2 = "/api/v1/user/customerProfile/login";
var_export(parseUrlSplit($url2));
echo PHP_EOL . PHP_EOL;

function parseUrlSplit($url, $delimiter = '/', $limit=20) {
    $retData = ['url'=>$url,
                'path'=>'',
                'service'=>'', //服务名
                'version'=>'', //接口版本
                'controller'=>'', //控制器
                'func'=>''];   //控制器方法
    $urlInfo = explode('?', $url, 2);
    $urlInfo[0] = trim($urlInfo[0], '/');
    $retData['path'] = $urlInfo[0];

    $urlAry = explode($delimiter, $urlInfo[0], $limit);
    if(!empty($urlAry)) {
        $i = 0;
        $controller = [];
        $unitNum = count($urlAry);
        if($unitNum>=4) {
            $retData['func'] = array_pop($urlAry);
        }
        foreach($urlAry as $_k=>$_v) {
            if(!$_v) {continue;}
            //判断每段值是否合法，每段必须是字母开头且只能由字母、数字、下划线组成
            $reg = '/^[a-z][a-z0-9_]*$/i';
            if(!preg_match($reg, $_v)) {
                return []; //返回空数据表示不合法
            }
            ++$i;
            if(1 == $i) {
                continue;
            }
            if(2 == $i) {
                $retData['version'] = $_v;
            } else if(3 == $i) {
                $retData['service'] = $_v;
            } else {
                $controller[] = $_v;
            }
        }
        $retData['controller'] = implode("\\", $controller);
    }
    return $retData;
}

//获取到网关配置
function getGateWayConfig() {
    $config = array(
        // '/<类型>/<版本>/<服务>/xxx/<参数名但url是参数值>/$'=>['控制器类名', '方法名']
        '/<type>/<version>/<service>/shops/<cityId>/<shopId>/map$' => ['App\\Mobile\\Controllers\\V1\\Gateway', 'xxxAction'],
        '/<wechat>/shops/<cityId>$' => 'Demo_Controller_Shop/default',
        '/<wechat>/module/<moduleId>$' => 'Demo_Controller_Module/default',
        '/<wechat>/vote$' => 'Demo_Controller_Vote/default',
        '/<wechat>/vote/poll' => 'Demo_Controller_Vote/poll',
        '/<wechat>/lbs$' => 'Demo_Controller_LBS/default',
        '/<wechat>/$' => 'Demo_Controller_LBS/default',
        '/<wechat>$' => 'Demo_Controller_Index/default',
    );
}


function parser01($url, $ignorePrefix='', $limit=20) {
    $retData = [];
    $url = trim($url, '/');
    if($ignorePrefix && preg_match('/^'.$ignorePrefix.'\//',$url)) {
        $url = mb_substr($url, mb_strlen($ignorePrefix)+1);
    }
    if(empty($url)) {
        return $retData;
    }
    $urlAry = explode('/', $url, $limit);
    $controller = [];
    $unitNum = count($urlAry);
    if($unitNum>=2) {
        $retData['function'] = array_pop($urlAry); //最后一个作为方法名
    } else {
        $retData['function'] = '';
    }
    foreach($urlAry as $_k=>$_v) {
        if(!$_v) {continue;}
        //判断每段值是否合法，每段必须是字母开头且只能由字母、数字、下划线组成,否则php命名空间出错
        $reg = '/^[a-z][a-z0-9_]*$/i';
        if(!preg_match($reg, $_v)) {
            return []; //返回空数据表示不合法
        }
        $controller[] = ucfirst($_v);
    }
    $retData['controller'] = implode("\\", $controller);
    return $retData;
}
$url = 'coupon/v1/coupon/info'; // 或 v1/coupon/info
var_export(parser01($url));
/**
array (
'function' => 'info',
'controller' => 'Coupon\\V1\\Coupon',
)
 */
echo PHP_EOL . PHP_EOL;
var_export(parser01($url, 'coupon'));
/**
array (
'function' => 'info',
'controller' => 'V1\\Coupon',
)
 */
$url = 'v3/coupon/info';
var_export(parser01($url, 'coupon'));
/**
array (
'function' => 'info',
'controller' => 'V3\\Coupon',
)
 */
var_export(parser01('', 'coupon'));
