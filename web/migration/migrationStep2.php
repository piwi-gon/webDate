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
$data = $oWebDate->queryAllData();
$oWebDate->truncateOldData();
echo "<pre>";
echo "try to add recipient:\n";
$recipientId = $oWebDate->addRecipient("Rolf Herrmann <info@wondernet24.de>", "info@wondernet24.de");

$month= ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
foreach($month as $mon) {
    $data = $oWebDate->queryAllData($mon);
    foreach($data as $row) {
//        ($message, $day, $month, $year, $recipientId)
        $oWebDate->addScheduleEntry($row['Nachricht'], $row['Tag'], $row['Monat'], $row['Jahr'], 2);
    }
}
echo "</pre>";
echo "success";
?>
