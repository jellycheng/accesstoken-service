<?php
require __DIR__ . '/common.php';

$config = include __DIR__ . '/config/Qq.php';
$qc = new \CjsLogin\QQ\QC($config);
$login_url = $qc->qq_login();
header("Location:$login_url");

