<?php
namespace App\Util;

use App\Library\Exceptions\ServiceException;

/**
 * 并发请求类
 * @author chengjinsheng
 */
class BfCurl
{

    /**
     * 获取接口返回的Data部分数据，只支持内部服务返回固定格式(code,msg,data)
     * @param $key
     * @param $res
     * @param bool $exception
     * @return array
     * @throws ServiceException
     */
    public static function getResultData($key,$res,$exception = true){
        $result = self::getResult($key,$res,$exception);
        if(empty($result)){
            return [];
        }
        $result = $result->getResult();
        $result = json_decode($result,true);
        if($result['code'] && $exception){
            throw new ServiceException($result['code'],$result['msg']);
        }
        return isset($result['data'])?$result['data']:[];
    }

    /**
     * 获取调用结果
     * @param $key
     * @param $res
     * @param bool $exception
     * @return array
     */
    public static function getResult($key,$res,$exception = true){
        if(empty($res)){
            return [];
        }
        if(isset($res[$key]) && $res[$key] instanceof DataRet && !$res[$key]->getErrno() ) {
            $res = $res[$key];
            return $res;
        }
        if($exception){
            throw new ServiceException('请求login发生网络异常');
        }
        return [];
    }

    /**
     * Get 请求
     * @param $url
     * @param array $param
     * @return false|resource
     */
    public static function get($url,$param = []){
        if($param){
            $url .= '?'.http_build_query($param);
        }
        return self::getCurlHandle(
            [
                CURLOPT_URL => $url,
                CURLOPT_HEADER => 0,
                CURLOPT_RETURNTRANSFER => 1,
            ]
        );
    }

    /**
     * Post 请求
     * @param $url
     * @param $param
     * @return false|resource
     */
    public static function post($url,$param){
        return self::getCurlHandle(
            [
                CURLOPT_URL => $url,
                CURLOPT_HEADER => 0,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => http_build_query($param),
            ]
        );
    }

    public static function getCurlHandle($options = []) {
        $ch = curl_init();
        foreach ((array)$options as $option=>$v) {
            curl_setopt($ch, $option, $v);
        }
        return $ch;
    }


    public static function doRequest($handleAry = []) {
        $ret = [];
        $mh = curl_multi_init();
        foreach ($handleAry as $handle) {
            if($handle) {
                curl_multi_add_handle($mh, $handle);
            }
        }
        //执行
        $still_running = null;
        do {
            $mrc = curl_multi_exec($mh, $still_running);
        } while (CURLM_CALL_MULTI_PERFORM === $mrc);

        while ($still_running && CURLM_OK === $mrc) {
            if (curl_multi_select($mh) == -1) {
                usleep(1);
            }
            do {
                $mrc = curl_multi_exec($mh, $still_running);
            } while (CURLM_CALL_MULTI_PERFORM === $mrc);
        }

        if (CURLM_OK === $mrc) {//并发没有问题，获取结果
            foreach ($handleAry as $chKey => $ch) {
                $errstr = curl_error($ch);
                if ($errstr) {
                    $errno = curl_errno($ch)?:999999;//有时候发生错误时，错误号也是0
                    $ret[$chKey] = DataRet::getInstance()->setErrmsg($errstr)->setErrno($errno);
                } else {
                    $ret[$chKey] = DataRet::getInstance()->setResult(curl_multi_getcontent($ch));
                }
            }
        }

        foreach ($handleAry as $handle2) {
            if($handle2) {
                curl_multi_remove_handle($mh, $handle2);
            }
        }

        curl_multi_close($mh);
        return $ret;

    }

}