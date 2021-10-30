<?php
require_once(dirname(__DIR__) . '/libs/mysql.php');

$dbName = 'baitaplon';
$dbUser = 'baitaplon';
$dbPass = 'baitaplon';
$dbHost = 'baitaplon';

$db = new Mysql($dbHost, $dbUser, $dbPass, $dbName);

/*
* Please disable strict mode and remove the comment on line 14
* */
function my_error_handler($error_no, $error_msg)
{
    //    header("location: error.php");
}

set_error_handler("my_error_handler");
