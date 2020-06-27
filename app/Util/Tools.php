<?php
namespace App\Util;
class Tools {

    //分支名 \App\Util\Tools::getBranchname()
    public static function getBranchname() {
        static $branchname = null;
        if(is_null($branchname)) {
            $branchname = isset($_SERVER['BRANCH_NAME'])?$_SERVER['BRANCH_NAME']:'';
        }
        if(!$branchname) {
            $branchname = isset($_SERVER['HTTP_BRANCHNAME'])?$_SERVER['HTTP_BRANCHNAME']:'';
        }
        return $branchname?:'master';
    }

    public static function parserPath($url, $ignorePrefix='', $limit=20) {
        $retData = [];
        $url = trim($url, '/');
        if($ignorePrefix && preg_match('/^'.$ignorePrefix.'\//',$url)) {
            $url = mb_substr($url, mb_strlen($ignorePrefix)+1);
        }
        if(empty($url)) {
            return $retData;
        }
        $urlAry = explode('/', $url, $limit);
        $controller = [];
        $unitNum = count($urlAry);
        if($unitNum>=2) {
            $retData['function'] = array_pop($urlAry); //最后一个作为方法名
        } else {
            $retData['function'] = '';
        }
        foreach($urlAry as $_k=>$_v) {
            if(!$_v) {continue;}
            //判断每段值是否合法，每段必须是字母开头且只能由字母、数字、下划线组成,否则php命名空间出错
            $reg = '/^[a-z][a-z0-9_]*$/i';
            if(!preg_match($reg, $_v)) {
                return []; //返回空数据表示不合法
            }
            $controller[] = ucfirst($_v);
        }
        $retData['controller'] = implode("\\", $controller);
        return $retData;
    }

}