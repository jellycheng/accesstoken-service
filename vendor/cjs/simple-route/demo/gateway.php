<?php
include __DIR__ . '/common.php';

$exampleGWobj = new \CjsSimpleRoute\ExampleGateWay();
$pattern = '/<type>/<version>/<service>/shops/<cityId>/<shopId>/map$';
$res = $exampleGWobj->getTag4Pattern($pattern);
var_export($res);
/**
array (
    0 =>array (
        0 => '<type>',
        1 => '<version>',
        2 => '<service>',
        3 => '<cityId>',
        4 => '<shopId>',
    ),
    1 => array (
        0 => 'type',
        1 => 'version',
        2 => 'service',
        3 => 'cityId',
        4 => 'shopId',
    ),
)
 */
echo PHP_EOL . PHP_EOL;

$pattern = 'ssssssss';
$res = $exampleGWobj->getTag4Pattern($pattern);
var_export($res);
/**
array ( 0 =>array (),
        1 =>array (),
    )
 */
echo PHP_EOL . PHP_EOL;


$exampleGWobj->appendGateWayConfig('/<type>/<version>/<service>/shops/<cityId>/<shopId>/map$',
                                  ['App\\Mobile\\Controllers\\V1\\Gateway', 'xxxAction']
                                );
$exampleGWobj->appendGateWayConfig('/<wechat>$',
                                        ['App\\Mobile\\Controllers\\V1\\Gateway', 'wechatAction']
                                    );
$exampleGWobj->appendGateWayConfig('/api/<version>/<service>/',
                                        ['App\\Mobile\\Controllers\\V1\\Gateway', 'apiAction']
                                    );
$exampleGWobj->appendGateWayConfig('/hdsapi(/)*$',
                                    ['App\\Mobile\\Controllers\\V1\\Gateway', 'hdsapiAction']
                                );

$url = "/api/v1/user/wechat/xx/exitCustomerProfileUnionid?a=1&b=3#xyz"; //$url = $_SERVER['REQUEST_URI'];
$res2 = $exampleGWobj->parse($url);
var_export($res2);
echo PHP_EOL . PHP_EOL;
echo "service:" . $res2['param']['service'] . PHP_EOL;

$url = "/v1/coupon/info?a=1&b=3#xyz"; //没有匹配的情况
$res2 = $exampleGWobj->parse($url);
var_export($res2);
echo PHP_EOL . PHP_EOL;

$url = "/hello"; //匹配一个目录情况
$res2 = $exampleGWobj->parse($url);
var_export($res2);
echo PHP_EOL . PHP_EOL;


$url = "/hdsapi/"; //匹配一个目录情况
$res2 = $exampleGWobj->parse($url);
var_export($res2);
echo PHP_EOL . PHP_EOL;
var_export($exampleGWobj->getParseResult());
echo PHP_EOL . PHP_EOL;
