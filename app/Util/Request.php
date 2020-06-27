<?php
namespace App\Util;

class Request
{
    protected static $instance;
    
    private $uri;
    private $protocol;
    private $get;
    private $post;
    private $requests;
    
    
    public function __construct()
    {
        $this->uri = $_SERVER['REQUEST_URI'] ?? $_SERVER['PHP_SELF'] . ($_SERVER['QUERY_STRING'] ? '?' . $_SERVER['QUERY_STRING'] : '');
        $this->protocol = empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === 'off' ? 'http' : 'https';
        $this->get = &$_GET;
        $this->post = &$_POST;
        $this->requests = &$_REQUEST;
    }
    
    /**
     * 初始化
     * @access public
     * @return Request
     */
    public static function instance() :Request
    {
        if (self::$instance === null) {
            self::$instance = new static();
        }
        return self::$instance;
    }
    
    /*
     * 协议头
     */
    public function protocol($url = false) :string
    {
        return $this->protocol . ($url ? '://' : '');
    }
    
    /*
     * 基本uri
     */
    public function uri() :string
    {
        return $this->uri;
    }
    
    /*
     * get请求
     */
    public function get($name = null, $default = null)
    {
        return is_null($name) ? $this->get : (array_key_exists($name, $this->get) ? $this->get[$name] : $default);
    }

    /*
     * post请求
     */
    public function post($name = null, $default = null)
    {
        return is_null($name) ? $this->post : (array_key_exists($name, $this->post) ? $this->post[$name] : $default);
    }

    public function getJson() {
        $data = '';
        $method = strtolower($_SERVER['REQUEST_METHOD']);
        if('post' == $method) {
            $data = file_get_contents("php://input");
        }
        if(!$data) {
            if('get' == $method) {
                $data = isset($_GET['jsondata'])?$_GET['jsondata']:[];
            } else if('post' == $method) {
                $data = isset($_POST['jsondata'])?$_POST['jsondata']:[];
            }
        }
        if($data){
            $data = @json_decode($data, true);
            if(empty($data)) {
                $data = [];
            }
        } else {
            $data = [];
        }
        return $data;
    }

    /*
     * request请求
     */
    public function requests($name = null, $default = null)
    {
        return is_null($name) ? $this->requests : (array_key_exists($name,
            $this->requests) ? $this->requests[$name] : $default);
    }

    /**
     * 获取URL用户token参数
     */
    public function getUserToken(){
        $tmp = $this->getJson();
        $userToken = isset($tmp['token'])?$tmp['token']:'';
        if(empty($userToken)){
            $userToken = isset($_GET['token'])?trim($_GET['token']):Header::getToken();
        }
        if(!$userToken) {
            return '';
        }
        //由英文、数字包括中划线组成的字符串
        $isMatched = preg_match('/^[A-Za-z0-9-]+$/', $userToken, $matches);
        if($isMatched && isset($matches[0]) && $matches[0] === $userToken){
            return $userToken;
        }
        return '';
    }

    /**
     * 获取外部系统代号
     * @return mixed|string
     * @date 2019-08-02
     */
    public function getOutSystem(){
        $request = $this->getJson();
        $params = isset($request['outSystem'])?$request['outSystem']:'';
        return $params;
    }

    /**
     * 获取响应结果格式
     * @return mixed|string
     */
    public function getRespProtocol(){
        $request = $this->getJson();
        $params = isset($request['respProtocol'])?$request['respProtocol']:0;
        return $params;
    }

    /**
     * 获取入参Param对象
     * @return mixed|string
     */
    public function getAnChangParam(){
        $request = $this->getJson();
        $params = isset($request['param'])?$request['param']:0;
        return $params;
    }

}