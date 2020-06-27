<?php
/**
 * 网关基础类
 * User: jelly
 * Date: 2019/7/7
 * Time: 11:09
 */
namespace CjsSimpleRoute;


class BaseGateWay {

    //[ '/<类型>/<版本>/<服务>/xxx/<匹配url path的参数名>/$'=>['控制器类名', '方法名'] ]
    protected $gateWayConfig = [];
    protected $parseResult = [];

    /**
     * 提取<>中的内容
     * @param $pattern = '/<type>/<version>/<service>/shops/<cityId>/<shopId>/map$'
     * @return array = [[完整匹配1, 完整匹配N], [去掉<>匹配1， 去掉<>匹配N]]
     */
    public function getTag4Pattern($pattern) {
        $ret = [[], []];//存放所有匹配结果
        if (preg_match_all('/<(.+?)>/', $pattern, $matches)) {
            $ret = $matches;
        }
        return $ret;
    }

    public function getGateWayConfig()
    {
        return $this->gateWayConfig;
    }

    public function setGateWayConfig($gateWayConfig)
    {
        $this->gateWayConfig = $gateWayConfig;
        return $this;
    }

    public function appendGateWayConfig($key, $val)
    {
        $this->gateWayConfig[$key] = $val;
        return $this;
    }

    //生成正则表达式
    public function buildPattern($pattern) {
        $pattern = preg_replace(array('/\//', '/<.+?>/'), array('\/', '([^\/]+)'), $pattern);
        //echo $pattern . PHP_EOL;
        return $pattern;
    }

    public function matchParams($paramValue, $tagKeys) {
        $ret = [];
        if (count($tagKeys)) {
            array_shift($paramValue);//将数组开头的单元移出数组
            $ret = array_combine($tagKeys, $paramValue);
            //array_combine — 创建一个数组，用一个数组的值作为其键名，另一个数组的值作为其值
        }
        return $ret;
    }

    public function init($configFile) {
        $config = include $configFile;
        foreach ($config as $k=>$v) {
            $this->appendGateWayConfig($k, $v);
        }
    }

    //没有匹配到返回空数组
    public function parse($uri) {
        $ret =[];
        $uriInfo = explode('?', $uri, 2);
        $uriPath = $uriInfo[0];

        $gateWayConfig = $this->getGateWayConfig();
        foreach($gateWayConfig as $pattern=>$val) {
            if (preg_match('/^' . $this->buildPattern($pattern) . '/', $uriPath, $matches)) {//找到符合规则
                $tagKeys = $this->getTag4Pattern($pattern);
                $newMatchUrlParam = $this->matchParams($matches, $tagKeys[1]);
                $ret['pattern'] = $pattern;
                $ret['val'] = $val;
                $ret['param'] = $newMatchUrlParam;
                $this->parseResult = $ret;
                return $ret;
            }
        }
        $this->parseResult = $ret;
        return $ret;

    }

    public function getParseResult() {
        return $this->parseResult;
    }

}