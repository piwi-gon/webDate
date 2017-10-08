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

session_start();
error_reporting(E_ALL&~E_NOTICE);
@define("DS", DIRECTORY_SEPARATOR);
require_once(dirname(__FILE__).DS."classes".DS."cWebDate.inc.php");
$oWebDate = new cWebDate();

@define(DEBUG, true);

function checkAuth() {
    if(!$_SESSION['AUTH']) {
        header("Location: helper/configurationLogin.php");
        exit;
    }
}
?>