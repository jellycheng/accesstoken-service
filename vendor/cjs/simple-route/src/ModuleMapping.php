<?php
namespace CjsSimpleRoute;

/**
 * 模块名=>控制器命名空间映射关系
 */
class ModuleMapping {
    
    protected $map = []; // ['模块名'=>'命名空间', 'user'=>'\\App\\User\\' ]

    protected $defaultMapNamespace = '\\App\\Controllers\\';

    protected function __construct() {

    }

    /**
     * 实例化对象，单例
     *
     */
    public static function getInstance() {
        static $instance;
        if(!$instance) {
            $instance = new static;
        }
        return $instance;
    }

    /**
     * 增加数据
     *
     */
    public function addMap($moduleName, $namespace='') {
        if(is_array($moduleName)) {
            $this->map = array_merge($this->map, $moduleName);
        } else {
            $this->map[$moduleName] = $namespace;
        }
        return $this;
    }

    /**
     * 删除数据
     *
     */
    public function delMap($moduleName) {
        if(!$moduleName) {
            return $this;
        }
        $dataSource = $this->map;
        if(is_array($moduleName)) {
            foreach ($dataSource as $key=>$val) {
                if(in_array($key, $moduleName)) {
                    unset($this->map[$key]);
                }
            }
        } else {
            foreach ($dataSource as $key=>$val) {
                if($key == $moduleName) {
                    unset($this->map[$key]);
                }
            }
        }
        return $this;
    }

    /**
     * 清空数据
     *
     */
    public function clearMap() {
        $this->map = [];
        return $this;
    }


    public function setDefaultMapNamespace($nameSpace) {
        $this->defaultMapNamespace = $nameSpace;
        return $this;
    }

    public function getDefaultMapNamespace() {
        return $this->defaultMapNamespace;
    }
    
    /**
     * 获取所有数据
     *
     */
    public function getMap($moduleName = null) {
        if(is_null($moduleName)) {
            return $this->map;
        }
        return isset($this->map[$moduleName])?$this->map[$moduleName]:$this->getDefaultMapNamespace();
    }

}
