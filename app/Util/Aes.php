<?php namespace App\Util;

/**
 * AES加密解密算法
 *
 */
class Aes
{
    /**
     *  加密关键Key
     */
    const OPENSSL_ENCRYPT_KEY = 'NAQEBBQADSwAwSAJ';
    /**
     * VI 必须是16长度
     */
    const OPENSSL_ENCRYPT_VI = 'VfLHQWqpQFOjSGHW';
    /**
     * 密码学方式。openssl_get_cipher_methods() 可获取有效密码方式列表
     */
    const METHOD = 'AES-128-CBC';

    /**
     * AES加密
     *
     * @author chengjinsheng
     * @date 2016-10-11
     * @param string $key 密钥
     * @param string $str 需加密的字符串
     * @return string
     */
    public static function encode($key, $str)
    {
        #以指定的方式和 key 加密数据，成功时返回加密后的字符串
        $encrypted = openssl_encrypt($str,self::METHOD,self::OPENSSL_ENCRYPT_KEY, OPENSSL_RAW_DATA ,self::OPENSSL_ENCRYPT_VI,$tag,$key);
        #加密后的内容通常含有特殊字符，需要编码转换下，在网络间通过url传输时要注意base64编码是否是url安全的
        return base64_encode($encrypted);
    }

    /**
     * AES解密
     *
     * @author chengjinsheng
     * @date 2016-10-11
     * @param string $key 密钥
     * @param string $str 需解密的字符串
     * @return string
     */
    public static function decode($key, $str)
    {
        $encrypted = base64_decode($str);
        #以指定的方式和 key 加密数据，成功时返回加密后的字符串
        return openssl_decrypt($encrypted, self::METHOD,self::OPENSSL_ENCRYPT_KEY,OPENSSL_RAW_DATA,self::OPENSSL_ENCRYPT_VI,null,$key);
    }
}
