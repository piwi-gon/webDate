<?php
/**
 *
 * saveEMailRecipientData.inc.php
 *
 * author : piwi
 *
 * created: 17.12.2016
 * changed: 17.12.2016
 *
 * purpose:
 *
 */

ini_set("display_errors", 1);
@define("DS", DIRECTORY_SEPARATOR);
require_once(dirname(__FILE__).DS."..".DS."main".DS."baseStart.inc.php");
$dateTokens = explode(".", $_POST['scheduleDate']);
checkAuth();
echo $oWebDate->addRecipient($_POST['emailRecipientName'], $_POST['emailRecipientAddress']);
?>