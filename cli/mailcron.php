<?php
/**
 *
 * mailcron.php
 *
 * author : piwi
 *
 * created: 02.11.2016
 * changed: 02.11.2016
 *
 * purpose:
 *
 */

@define("DS", DIRECTORY_SEPARATOR);
$currentDirectory = dirname(__FILE__);
$currentlog = $currentDirectory.DS."mail.log";
error_log(date('Ymd His').": current Dir: " . $currentDirectory . "\n", 3, $currentlog);
require_once($currentDirectory . DS . "clistart.inc.php");
$additionalHeader = "From: WebdateV2.0 &lt;webdate@wondernet24.de&gt;";
$from = "webdate@wondernet24.de";
if($_GET['recipientAddress']!="") {
    $rec['recipient_address'] = urldecode($_GET['recipientAddress']);
    $rec['message'] = urldecode($_GET['message']);
    error_log(date('Ymd His').": now mailing '" . $rec['message'] . "' to '" . $rec['recipient_address'] . "'\n", 3, $currentlog);
    mail($rec['recipient_address'], $from, $rec['message'], $additionalHeader);
} else {
    error_log(date('Ymd His').": no params found  - using default\n", 3, $currentlog);
    $recipients = $oWebdate->queryRecipients();
    foreach($recipients as $rec) {
        $data = $oWebdate->queryCalendarData($rec['recipient_id']);
        if(count($data)>0) {
            foreach($data as $row) {
                error_log(date('Ymd His').": now mailing '" . $row['message'] . "' to '" . $rec['recipient_address'] . "'\n", 3, $currentlog);
                if(strpos($rec['recipient_address'], ",")!==false) {
                    $adresses = explode(",", $rec['recipient_address']);
                    foreach($adresses as $adr) {
                        mail($adr, $from, $row['message'], $additionalHeader);
                    }
                } else {
                    mail($rec['recipient_address'], $from, $row['message'], $additionalHeader);
                }
            }
        }
    }
}
?>