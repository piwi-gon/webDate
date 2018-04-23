<?php
/**
 *
 * readRecipientById.inc.php
 *
 * author : piwi
 *
 * created: 08.01.2017
 * changed: 08.01.2017
 *
 * purpose:
 *
 */

session_start();
@define("DS", DIRECTORY_SEPARATOR);
require_once(dirname(__FILE__).DS."..".DS."main".DS."baseStart.inc.php");
$rec = $oWebDate->queryRecipient($_GET['selectedRecipientId']);
echo $rec['recipient_id'] . "|".$rec['recipient_name'];
