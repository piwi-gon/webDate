<?php
/**
 *
 * baseStart.inc.php
 *
 * author : piwi
 *
 * created: 04.11.2016
 * changed: 04.11.2016
 *
 * purpose:
 *
 */

$wwwDir = str_replace("helper", "", dirname($_SERVER['PHP_SELF']));
if(substr($wwwDir, -1) != "/") { $wwwDir .= "/"; }
@define("WEBDATE_WWW_DIR", $wwwDir);
if (session_status() == PHP_SESSION_NONE) {
    session_start();
} else {
    session_start();
}
error_reporting(E_ALL&~E_NOTICE);
@define("DS", DIRECTORY_SEPARATOR);
require_once(dirname(__FILE__).DS."classes".DS."mysql.inc.php");
$oSQL = new cMySQLi();
require_once(dirname(__FILE__).DS."classes".DS."cWebDate.inc.php");
$oWebDate = new cWebDate();

@define(DEBUG, true);

checkAuth();

function checkAuth() {
    if(!$_SESSION['AUTH']
            && strpos($_SERVER['PHP_SELF'], "configurationLogin.php")===false
            && strpos($_SERVER['PHP_SELF'], "checkLogin.php")===false
            && strpos($_SERVER['PHP_SELF'], "passwordLostDialog.php")===false
            && strpos($_SERVER['PHP_SELF'], "webdateMain.php")===false) {
        header("Location: ".WEBDATE_WWW_DIR."helper/configurationLogin.php");
        exit;
    }
}
?>