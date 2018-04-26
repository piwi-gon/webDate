<?php
/*
 * saveNewPassword.php
 *
 * author: klaus
 *
 * created: 26.04.2018
 * changed: 26.04.2018
 *
 */

ini_set("display_errors", 1);
@define("DS", DIRECTORY_SEPARATOR);
require_once(dirname(__FILE__).DS."..".DS."main".DS."baseStart.inc.php");
checkAuth();
$result = $oWebDate->changeLoginPassword($_SESSION['LOGINID'], $_POST);
echo $result;
