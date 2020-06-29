<?php
namespace CjsSimpleRoute;


class SingletonGw extends BaseGateWay
{

    protected function __construct()
    {

    }

    public static function getInstance() {
        static $instance;
        if(!$instance) {
            $instance = new static();
        }
        return $instance;
    }

}
