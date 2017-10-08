<?php
/**
 *
 * saveScheduleData.php
 *
 * author : piwi
 *
 * created: 26.11.2016
 * changed: 26.11.2016
 *
 * purpose:
 *
 */

@define("DS", DIRECTORY_SEPARATOR);
require_once(dirname(__FILE__).DS."..".DS."main".DS."baseStart.inc.php");
$dateTokens = explode(".", $_POST['scheduleDate']);
$_POST['scheduleDateISO'] = $dateTokens[2]."-".
                            sprintf("%02d", $dateTokens[1])."-".
                            sprintf("%02d", $dateTokens[0]);
echo $oWebDate->saveEntry($_POST);
?>