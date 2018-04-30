<?php
/*
 * sendNewGeneratedPassword.php
 *
 * author: klaus
 *
 * created: 30.04.2018
 * changed: 30.04.2018
 *
 */

session_start();
@define("DS", DIRECTORY_SEPARATOR);
require_once (dirname(__FILE__) . DS . ".." . DS . "main" . DS . "baseStart.inc.php");

$oWebDate->generateAndSendNewPassword($recipientName);