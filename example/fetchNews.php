<?php
include '../vendor/autoload.php';
require '../Core.php';

use Sample\Sdk\UserGroup\Repository\UserGroupRepository;

$core = Marmot\Core::getInstance();
$core->initCli();

$userGroupResitory = new UserGroupRepository();

$userGroup = $userGroupResitory->fetchOne(1);
var_dump($userGroup);

// $userGroup = $sdk->userGroupResitory()->fetchOne(0);

// var_dump($sdk->userGroupResitory()->lastErrorId());
// var_dump($sdk->userGroupResitory()->lastErrorInfo());