<?php
require dirname(__DIR__) . '/bootstrap/autoload.php';

header('Content-type: application/json;charset=utf-8');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:OPTIONS, GET, POST, PUT, DELETE');
$corsHeaders = env("CORS_HEADERS", "content-type,Authorization,token,app-platform,app-device-id,app-type,app-device-model,app-v,branchname,enterprise-id,x-account-type,track-site-name,track-jv-company,track-user-level,*");
header('Access-Control-Allow-Headers: ' . $corsHeaders);
if('OPTIONS' == strtoupper($_SERVER['REQUEST_METHOD'])) {
    exit();
}

$routeObj = CjsSimpleRoute\Route::getInstance()->init('\\App\\Controllers\\')->setUrlPattern('');
$res = $routeObj->run(function($me){
    $ret = [
        'className'=>$me->getAppCtlNamespace() . 'IndexController',
        'method'=>"indexAction", //默认方法
    ];
    $uri = $me->getUri();
    $gateWayRet = \CjsSimpleRoute\SingletonGw::getInstance()->parse($uri);
    if($gateWayRet && isset($gateWayRet['val']) && $gateWayRet['val']) {//匹配网关
        $ret['className'] = $gateWayRet['val'][0];
        $ret['method'] = $gateWayRet['val'][1];
        return $ret;
    }
    $uriInfo = explode('?', $uri, 2);
    $uriPath = trim(array_shift($uriInfo), '/');

    if (!empty($uriPath)) {
        if(preg_match('/^v([0-9]+)_([a-z_]+)/i', $uriPath)) {//类似这种接口/v1_gateway_coupon/info
            $uriPath =  explode('/', $uriPath);
            $ret['className'] = sprintf('%s%sController', $me->getAppCtlNamespace(), ucfirst(preg_replace_callback('/(_|-|\.)([a-zA-Z])/', function($match){return '\\'.strtoupper($match[2]);}, $uriPath[0])) );
            if (isset($uriPath[1])) {
                $ret['method'] =  $uriPath[1] . 'Action';
                unset($uriPath[0], $uriPath[1]);
            } else {
                unset($uriPath[0]);
            }
        } else { // v1/coupon/info 或 xxx/v1/coupon/info
            $tmp = \CjsSimpleRoute\Util::parserPath($uriPath, '');
            $ret['className'] = sprintf('%s%sController', $me->getAppCtlNamespace(),$tmp['controller']);
            $ret['method'] =  $tmp['function'] . 'Action';

        }
    }
    return $ret;
});
if($routeObj->getRouteExists()){
    if(is_array($res)) {
        if(!isset($res['data']) || !$res['data'] || is_null($res['data'])) {
            $res['data'] = new \stdClass();
        }
        echo json_encode($res, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
    } else {
        echo $res;
    }
} else {
    $notfoundObj = new \App\Controllers\NotfoundController();
    $res = $notfoundObj->indexAction();
    echo json_encode($res, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);

}
