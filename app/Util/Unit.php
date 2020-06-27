<?php
namespace App\Util;

class Unit
{
    /**
     * 将人民币单位分转化为元
     * @param integer
     * @return string
     */
    public static function fen2yuan($param,$default = '0.00'){
        if(empty($param)){
            return $default;
        }
        $res = bcdiv($param,100,2);
        return strval($res);
    }
    
    /*
     * 分转换为元，且整数去掉小数点后的0  如2.00 => 2
     */
    public static function fen2yuan2int($fen)
    {
        $data = self::fen2yuan($fen);
        $list = explode('.', $data);
        if($list[1] == 0){
            return $list[0];
        }
        return (string)$data;
    }

     /**
     * 6位小数转化为2位
     * @param integer
     * @return string
     */
    public static function lessdecimal($param,$default = '0.00'){
        if(empty($param)){
            return $default;
        }
        $res = bcdiv($param,1,2);
        return strval($res);
    }

    /**
     * 中级及中级以上的用户分享价累加一个配置的价格
     *
     * @param  array $user_info
     * @param  int $share_price
     * @param  int $add_price
     *
     * @return int
     */
    public static function getSpecSharePrice($user_info , $share_price , $add_price = 0)
    {
        $sub_level = array_get($user_info, 'sub_level',0);
        if($sub_level > 50100 && !in_array($sub_level,[60100,60200,80100])) {
            return bcadd($share_price, $add_price);
        }
        return $share_price;
    }
}