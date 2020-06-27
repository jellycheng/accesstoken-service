<?php
namespace CjsLogin\Weixin;

class WxBase {
    protected $wxApiDomain;
    protected $wxConfig=[];
    protected $errno=0;
    protected $errmsg = '';

    public static function create() {
        return new static();
    }

    public function setWxDomain($wxDomain) {
        $this->wxApiDomain = $wxDomain;
        return $this;
    }

    public function getWxDomain() {
        return $this->wxApiDomain;
    }

    public function setWxConfig($param) {
        if(!is_array($param)){
            return $this;
        }
        if(isset($param['wx_api_domain']) && $param['wx_api_domain']) {
            $this->setWxDomain($param['wx_api_domain']);
        }
        $this->wxConfig = array_merge($this->wxConfig, $param);
        return $this;
    }

    public function getWxConfig($key=null, $default = '') {
        if(is_null($key)) {
            return $this->wxConfig;
        }
        if(isset($this->wxConfig[$key])) {
            return $this->wxConfig[$key];
        }
        $array = $this->wxConfig;
        $keyA = explode('.', $key);
        foreach ($keyA as $segment)
        {// a.b.c
            if ( ! is_array($array) || ! array_key_exists($segment, $array))
            {   //不存在的key则返回默认值
                return $default instanceof \Closure ? $default() : $default;
            }
            $array = $array[$segment];
        }
        return $array;
    }

    public function jsonEncode($param) {
        return json_encode($param, JSON_UNESCAPED_UNICODE);
    }

    public function jsonDecode($jsonStr, $assoc = true) {
        return json_decode($jsonStr, $assoc);
    }

    protected function setErrno($errno) {
        $this->errno = $errno;
        return $this;
    }

    public function getErrno() {
        return $this->errno;
    }

    protected function setErrmsg($errmsg) {
        $this->errmsg = $errmsg;
        return $this;
    }

    public function getErrmsg() {
        return $this->errmsg;
    }

    protected function setErr($errno, $errmsg)
    {
        $this->errno  = $errno;
        $this->errmsg = $errmsg;
        return $this;
    }

    protected function clearErr()
    {
        $this->errno  = 0;
        $this->errmsg = '';
        return $this;
    }

}
