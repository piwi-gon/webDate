<?php
/*
 * saveWebDateOptions.php
 *
 * author: klaus
 *
 * created: 28.04.2018
 * changed: 28.04.2018
 *
 */


session_start();
error_reporting(E_ALL&~E_NOTICE);
ini_set("display_errors", 1);
@define("DS", DIRECTORY_SEPARATOR);
require_once(dirname(__FILE__).DS."..".DS."main".DS."baseStart.inc.php");
$oWebDate->saveWebDateOptions($_POST);
?>