<?php
include '../vendor/autoload.php';
require '../Core.php';

$core = Marmot\Core::getInstance();
$core->initCli();

$sdk = new Sample\Sdk\Sdk('http://backend-sample-nginx/', array());

$userGroup = $sdk->userGroupResitory()->fetchOne(1);
var_dump($userGroup);

// $userGroup = $sdk->userGroupResitory()->fetchOne(0);

// var_dump($sdk->userGroupResitory()->lastErrorId());
// var_dump($sdk->userGroupResitory()->lastErrorInfo());