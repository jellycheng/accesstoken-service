<?php
namespace CjsLogin\QQ;
/* PHP SDK
 * @version 2.0.0
 * @author connect@qq.com
 * @copyright © 2013, Tencent Corporation. All rights reserved.
 */


class Recorder{

    private static $data;
    private $inc = [];

    public static function create() {
       return new static();
    }

    public function setInc($config) {
        if(!is_array($config)) {
            return $this;
        }
        $this->inc = array_merge($this->inc, $config);
        return $this;
    }

    public function __construct(){

//        if(empty($_SESSION['QC_userData'])){
//            self::$data = array();
//        }else{
//            self::$data = $_SESSION['QC_userData'];
//        }
    }

    public function write($name,$value=null){
        if(is_array($name)) {
            self::$data = $name;
        } else if($name) {
            self::$data[$name] = $value;
        }
        return $this;
    }

    public function read($name){
        if(!isset(self::$data[$name])){
            return null;
        }else{
            return self::$data[$name];
        }
    }

    public function readInc($name){
        if(!isset($this->inc[$name])){
            return null;
        }else{
            return $this->inc[$name];
        }
    }

    public function delete($name){
        unset(self::$data[$name]);
    }

    function __destruct(){
        //$_SESSION['QC_userData'] = self::$data;
    }
}
