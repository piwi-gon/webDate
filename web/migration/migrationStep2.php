<?php
/**
 *
 * migrationStep2.php
 *
 * author : piwi
 *
 * created: 13.11.2016
 * changed: 13.11.2016
 *
 * purpose:
 *
 */

ini_set("display_errors", 1);
@define("DS", DIRECTORY_SEPARATOR);
require_once(dirname(__FILE__).DS."..".DS."main".DS."classes".DS."mysql.inc.php");
$oSQL = new cMySQLi();
require_once(dirname(__FILE__).DS."..".DS."main".DS."baseStart.inc.php");
require_once(dirname(__FILE__).DS."..".DS."main".DS."classes".DS."WebDateMigration.inc.php");
$oWebDateMig = new WebDateMigration();
$oWebDate = new cWebDate();
$data = $oWebDateMig->queryAllData();
$month= ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
// $oWebDate->truncateOldData();
echo "<pre>";
echo "try to add recipient: 'info@wondernet24.de'\n";
$recipientId = $oWebDate->addRecipient(array("emailRecipientAddress"=>"info@wondernet24.de", "emailRecipientName"=>"Rolf Herrmann"));
if($recipientId > 0) {
    foreach($month as $mon) {
        $data = $oWebDateMig->queryAllData($mon);
        foreach($data as $row) {
            echo "try to add  '".$row['Nachricht'] . ", " . $row['Tag'] . ", " .$row['Monat'] . ", " .$row['Jahr'] . "\n";
            $oWebDate->addScheduleEntry($row['Nachricht'], $row['Tag'], $row['Monat'], $row['Jahr'], $recipientId);
        }
    }
    echo "</pre>";
    echo "success";
}
echo "failed";
?>
