<?php
require __DIR__ . '/common.php';
$config = include __DIR__ . '/config/Qq.php';
$qc = new \CjsLogin\QQ\QC($config);
echo $qc->qq_callback();
echo $qc->get_openid();
//$ret = $qc->get_info();
//$arr = $qc->get_user_info();