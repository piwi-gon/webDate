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
$installDir = dirname(__FILE__);

require_once($installDir . DS . "clistart.inc.php");

$recipients = $oWebdate->queryRecipients();
foreach($recipients as $rec) {
    $data = $oWebdate->queryCalendarData($rec['recipient_id']);
    if(count($data)>0) {
        foreach($data as $row) {
            $additionalHeader = "From: WebdateV2.0 <webdate@wondernet24.de>";
            $from = "webdate@wondernet24.de";
            echo "now mailing '" . $row['message'] . "' to '" . $rec['recipient_address'] . "'";
            // mail($rec['recipient_address'], $from, $row['message'], $additionalHeader);
        }
    }
}
?>