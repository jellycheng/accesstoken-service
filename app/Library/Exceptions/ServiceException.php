<?php namespace App\Library\Exceptions;

use Exception;
/**
 * 业务异常处理类
 */
class ServiceException extends Exception
{
    public static $aExceptions = null;
    protected $errno;

    /*
     * 异常构造类
     *
     * @param string $sExceptionKey required 异常KEY或者异常信息
     * @param string $sExceptionCode option 异常code ($sExceptionKey为异常信息时才有该字段)
     * @return array
     */
    public function __construct($sExceptionKey, $sExceptionCode = -1)
    {
        $this->errno = $sExceptionKey;
        self::setExceptions();
        if (isset(self::$aExceptions[$sExceptionKey])) {
            list($message, $code) = self::$aExceptions[$sExceptionKey];
            if (empty($code) && !is_null($sExceptionCode)) {
                parent::__construct($message, $sExceptionCode);
            } else {
                parent::__construct($message, $code);
            }
        } else {
            parent::__construct($sExceptionKey, $sExceptionCode);
        }
    }

    /**
     * 读取异常文件
     *
     * @throws Exception
     */
    public static function setExceptions()
    {
        $sFilename = dirname(__FILE__) . '/ExceptionCode.php';
        if (is_readable($sFilename)) {
            self::$aExceptions = require($sFilename);
        } else {
            parent::__construct('读取异常文件出错', 999998);
        }
    }

    /*
     * 获取异常Key
     *
     * @Param   bool    bIsCode 是否返回异常码
     * @return  mixed
     */
    public function getErrno($bIsCode = false)
    {
        return $bIsCode ? $this->getCode() : $this->errno;
    }

    /**
     * 判断当前code是否已经定义
     *
     * @param string $code required 异常code
     * @return boolean
     */
    public static function code($code)
    {
        self::setExceptions();
        return isset(self::$aExceptions[$code]) ? true : false;
    }
}
