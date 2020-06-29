<?php
namespace CjsSimpleRoute;


/**
 * method值路由（根据接口名称路由）
 * 格式：method=system.module.controller.func
 *      method=system.module.controller_part1...controller_partN.func
 * method=alipay.user.userinfo.share
 */
class MethodRouter {
    protected $method;  //通过路由参数获取的路由参数值
    protected $paramKey = 'method';//路由参数名
    const version = "1.0.0";
    protected $error_code = 0; //错误号，0正确，其它均发生错误
    protected $error_msg = 'ok'; //错误信息
    protected $formatData = [
                            'system'=>'', //系统  nfangbian_user
                            'module'=>'', //模块 user、org、auth
                            'controller'=>'', //控制器类（不含命名空间前缀） index、profile
                            'func'=>'', // 类方法 index、add、edit、delete
                            ];

    protected function __construct() { }

    public static function getInstance() {
        static $instance;
        if(!$instance) {
            $instance = new static();
        }
        return $instance;
    }

    public function init($method = null) {
        static $isInit;
        if($isInit) {
            return $this;
        }
        $isInit = true;
        if(is_null($method)) {
            $reqMethod = isset($_SERVER['REQUEST_METHOD'])?strtoupper($_SERVER['REQUEST_METHOD']):'GET'; //请求方式
            $paramKey = $this->getParamKey();
            if('GET' == $reqMethod) {
                $method = isset($_GET[$paramKey])?trim($_GET[$paramKey]):'';
            } else if('POST' == $reqMethod) {
                $method = isset($_POST[$paramKey])?trim($_POST[$paramKey]):'';
            }
        }
        $this->method = $method;
        return $this;
    }

    public function run($callback = '') {
        $methodAry = explode('.', $this->getMethod(), 20); //alipay.user.userinfo.share
        $ext = []; //未来扩展字段
        if(!empty($methodAry)) {
            $i = 0;
            $controller = [];
            $unitNum = count($methodAry);
            if($unitNum>=4) {
                $this->formatData['func'] = array_pop($methodAry);
            }
            foreach($methodAry as $_k=>$_v) {
                //判断每段值是否合法，每段必须是字母开头且只能由字母、数字、下划线组成
                $reg = '/^[a-z][a-z0-9_]*$/i';
                if(!preg_match($reg, $_v)) {
                    $this->error_code = 1;
                    $this->error_msg = 'method param error';
                }
                $i++;
                if(1 == $i) {
                    $this->formatData['system'] = $_v;
                } else if(2 == $i) {
                    $this->formatData['module'] = $_v;
                } else {
                    $controller[] = $_v;
                }
            }
            $this->formatData['controller'] = implode("\\", $controller);
        }
        if(is_callable($callback)) {
            return call_user_func_array($callback, [$this, $ext]);
        }
        return '';
    }


    public function getMethod() {
        return $this->method;
    }

    public function getFormatData() {
        return $this->formatData;
    }

    public function getParamKey() {
        return $this->paramKey?:'method';
    }

    public function setParamKey($key) {
        $this->paramKey = $key;
        return $this;
    }

    public function getError() {
        return [
                'error_code'=>$this->error_code,
                'error_msg'=>$this->error_msg
        ];
    }

}
