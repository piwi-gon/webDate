<?php
/*
 * saveRecipientAddress.php
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
$_POST['recipientId'] = $_SESSION['RECIPIENT_ID'];
$insertId = $oWebDate->changeRecipientAddress($_POST);
if(intval($insertId)>0) {
    echo "success";
} else {
    echo "failed";
}
