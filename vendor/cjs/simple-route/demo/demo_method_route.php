<?php
include __DIR__ . '/common.php';


//格式： 系统名.模块名.控制器目录1.方法名
//      系统名.模块名.控制器目录1.控制器目录N.方法名
$_GET['method'] = 'nfangbian.user.auth.login';
$_GET['method'] = 'nfangbian.user.api.user.login';
$res = \CjsSimpleRoute\MethodRouter::getInstance()->init()->run(function($methodObj, $ext){
                                                    $errorData = $methodObj->getError();
                                                    if(!$errorData['error_code']) {//正常
                                                        $msg = $errorData['error_msg'];

                                                    } else {
                                                        //发生错误
                                                        $msg = $errorData['error_msg'];
                                                    }
                                                    var_export($errorData);
                                                    var_export($methodObj->getFormatData());
                                                    echo $methodObj->getMethod() . PHP_EOL;
                                                    //开始路由
                                                    $content = 'content_' . date('Y-m-d H:i:s') . '_' . $msg . PHP_EOL; //执行结果
                                                    return $content;
                                                });
echo $res;

