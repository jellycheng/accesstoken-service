<?php
namespace App\Controllers;

class IndexController extends Base {

    public function indexAction()
    {
        return $this->responseSuccess(['tips'=>'服务正常',
                                        'cloud_name'=>getenv('CLOUD_NAME')],
                                    __METHOD__);
    }
}