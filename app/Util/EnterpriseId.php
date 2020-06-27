<?php
/**
 * 企业ID
 */

namespace App\Util;


class EnterpriseId
{
    protected $enterpriseid = 0;
    protected $job_enterpriseid = 0; //job设置的企业ID

    public static function getInstance() {
        static $instance;
        if(!$instance) {
            $instance = new static();
        }
        return $instance;
    }

    //获取企业ID
    public function getEnterpriseid() {
        return $this->job_enterpriseid?$this->job_enterpriseid:$this->enterpriseid;
    }

    //移动api入口获取企业请求头，并设置企业ID
    public function mobileApiEntrySetEnterpriseid() {
        $eid = isset($_SERVER['HTTP_ENTERPRISE_ID'])?$_SERVER['HTTP_ENTERPRISE_ID']:'0';
        $this->enterpriseid = intval($eid);
        return $this;
    }

    //内部服务与服务之间传输请求头，并设置企业ID
    public function serviceEntrySetEnterpriseid() {
        $eid = isset($_SERVER['HTTP_X_ENTERPRISE_ID'])?$_SERVER['HTTP_X_ENTERPRISE_ID']:'0';
        $this->enterpriseid = intval($eid);
        return $this;
    }

    //脚本设置企业ID
    public function jobSetEnterpriseid($eid) {
        $this->job_enterpriseid = intval($eid);
        return $this;
    }
    //清空job企业ID
    public function resetJobEnterpriseid() {
        $this->job_enterpriseid = 0;
        return $this;
    }

}