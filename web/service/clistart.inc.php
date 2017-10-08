<?php
/**
 *
 * clistart.inc.php
 *
 * author : piwi
 *
 * created: 28.12.2014
 * changed: 28.12.2014
 *
 * purpose:
 *
 */

// start a default session
session_start();

$REPONAME = "Standard";

@define("DS", DIRECTORY_SEPARATOR);

@define("MODULEREPOSITORY",     dirname(__FILE__) . DS . ".." . DS . "repository" . DS . "modules");
@define("EXTENSIONREPOSITORY",  dirname(__FILE__) . DS . ".." . DS . "repository" . DS . "extensions");
@define("SYSTEMREPOSITORY",     dirname(__FILE__) . DS . ".." . DS . "repository" . DS . "system");

require_once(dirname(__FILE__).DS."classes".DS."mysql.inc.php");
$oSQL = new cMySQLi();

?>