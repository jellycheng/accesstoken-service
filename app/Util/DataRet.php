<?php
namespace App\Util;

/**
 * 结果类
 */
class DataRet {

    private $errmsg = ''; //错误信息
    private $errno  = 0; //0表正常，非0表示发生错误
    private $result = null; //没有发生错误时，数据信息，字符串内容

    public static function getInstance() {
        return new static();
    }

    public function getErrmsg()
    {
        return $this->errmsg;
    }


    public function setErrmsg($errmsg)
    {
        $this->errmsg = $errmsg;
        return $this;
    }

    public function getErrno()
    {
        return $this->errno;
    }

    public function setErrno($errno)
    {
        $this->errno = $errno;
        return $this;
    }

    public function getResult()
    {
        return $this->result;
    }


    public function setResult($result) {
        $this->result = $result;
        return $this;
    }

}