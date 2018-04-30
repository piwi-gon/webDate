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
require_once($currentDirectory . DS . "clistart.inc.php");
$currentlog = $currentDirectory.DS.$oWebDate->getOptionValue("logfile");
$toLog = $oWebDate->getOptionValue("logging") == "true" ? true : false;
if($toLog) { error_log(date('Ymd His').": current Dir: " . $currentDirectory . "\n", 3, $currentlog); }
$additionalHeader = "From: ".$oWebDate->getOptionValue("sender_name")." <".$oWebDate->getOptionValue("sender_address").">";
$from = $oWebDate->getOptionValue("sender_address");
if($_GET['recipientAddress']!="") {
    $rec['recipient_address'] = urldecode($_GET['recipientAddress']);
    $rec['message'] = urldecode($_GET['message']);
    if($toLog) { error_log(date('Ymd His').": now mailing '" . $rec['message'] . "' to '" . $rec['recipient_address'] . "'\n", 3, $currentlog); }
    mail($rec['recipient_address'], $from, $rec['message'], $additionalHeader);
} else {
    if($toLog) {  error_log(date('Ymd His').": no params found  - using default\n", 3, $currentlog); }
    $recipients = $oWebdate->queryRecipients();
    foreach($recipients as $rec) {
        $data = $oWebdate->queryCalendarData($rec['recipient_id']);
        if(count($data)>0) {
            foreach($data as $row) {
                if($toLog) { error_log(date('Ymd His').": now mailing '" . $row['message'] . "' to '" . $rec['recipient_address'] . "'\n", 3, $currentlog); }
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