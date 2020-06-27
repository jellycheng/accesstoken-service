<?php
include __DIR__ . '/common.php';

//设置默认命名空间
\CjsSimpleRoute\ModuleMapping::getInstance()->setDefaultMapNamespace("Demo\\Controllers\\");

//设置模块对应的路由
\CjsSimpleRoute\ModuleMapping::getInstance()->addMap(
                                                    [
                                                        'user'=>'\\Demo\\Controllers\\',  //h5&app api
                                                        'useradmin'=>'\\App\\User\\Controllers\\Admin\\',  //admin api即admin ajax
                                                    ]
                                                );

$_GET['method'] = 'nfangbian.user.hi.sayAction';
$res = \CjsSimpleRoute\MethodRouter::getInstance()->init()->run(function($methodObj, $ext){
                                                    $is404 = false;
                                                    $errorData = $methodObj->getError();
                                                    if(!$errorData['error_code']) {//正常
                                                        $msg = $errorData['error_msg'];
                                                        $formatData = $methodObj->getFormatData();
                                                        $module = (isset($formatData['module']) && $formatData['module'])?strtolower($formatData['module']):'default';
                                                        $controller = (isset($formatData['controller']) && $formatData['controller'])?ucfirst($formatData['controller']).'Controller':'IndexController';
                                                        $func = (isset($formatData['func']) && $formatData['func'])?lcfirst($formatData['func']):'index';
                                                        $serviceNameCfg = \CjsSimpleRoute\ModuleMapping::getInstance()->getMap();
                                                        if(isset($serviceNameCfg[$module])) {
                                                            $namespace = $serviceNameCfg[$module];
                                                        } else {//没有映射模块
                                                            $namespace = \CjsSimpleRoute\ModuleMapping::getInstance()->getDefaultMapNamespace();
                                                        }
                                                        $class = sprintf('%s%s', $namespace, $controller);
                                                        //echo $class . PHP_EOL;
                                                        if (class_exists($class)) {
                                                             $controllerObj = new $class;
                                                             if($func && method_exists($controllerObj, $func)) {
                                                                $content = call_user_func(array($controllerObj, $func));
                                                             } else {
                                                                $is404 = true;
                                                             }

                                                        } else {
                                                            //404
                                                            $is404 = true;
                                                        }
                                                    } else {
                                                        //发生错误
                                                        $msg = $errorData['error_msg'];
                                                    }
                                                    if($is404) {
                                                        $msg = '404 - not found!';
                                                    }
                                                    var_export($errorData);
                                                    var_export($methodObj->getFormatData());
                                                    echo $methodObj->getMethod() . PHP_EOL;
                                                    //开始路由
                                                    if(is_array($content)) {
                                                        $content = var_export($content, 1);
                                                    }
                                                    $content = 'content_' . date('Y-m-d H:i:s') . '_' . $msg . $content . PHP_EOL; //执行结果
                                                    return $content;
                                                });
echo $res;

