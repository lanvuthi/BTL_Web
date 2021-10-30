<?php
require_once(dirname(__DIR__) . '/libs/mysql.php');

$dbName = 'baitaplon';
$dbUser = 'baitaplon';
$dbPass = 'baitaplon';
$dbHost = 'baitaplon';

$db = new Mysql($dbHost, $dbUser, $dbPass, $dbName);

