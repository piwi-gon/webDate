<?php
/**
 *
 * migrationStep1.php
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
define("DS", DIRECTORY_SEPARATOR);
require_once(dirname(__FILE__).DS."..".DS."main".DS."baseStart.inc.php");
require_once(dirname(__FILE__).DS."..".DS."main".DS."classes".DS."mysql.inc.php");
$oSQL = new cMySQLi();

$in['table'] = "r_schedule_recipient";
$in['sql']   = "CREATE TABLE IF NOT EXISTS r_schedule_recipient ( ".
                     "schedule_recipient_id           INT auto_increment primary key not null, ".
                     "fk_schedule_id                  INT, ".
                     "fk_recipient_id                 INT);";
$CREATE[] = $in;
unset($in);
$in['table'] = "t_schedule";
$in['sql'] = "CREATE TABLE IF NOT EXISTS t_schedule  (".
            "schedule_id                     INT auto_increment primary key not null,".
            "message                         TEXT,".
            "day                             INT,".
            "month                           INT,".
            "year                            INT,".
            "single_message                  TINYINT,".
            "is_used                         TINYINT,".
            "used_date                       TIMESTAMP)";
$CREATE[] = $in;
unset($in);
$in['table'] = "t_recipient";
$in['sql'] = "CREATE TABLE IF NOT EXISTS t_recipient (".
            "recipient_id                    INT auto_increment primary key not null,".
            "recipient_name                  VARCHAR(255)    DEFAULT ''      NOT NULL,".
            "recipient_address               VARCHAR(200)    DEFAULT ''      NOT NULL".
            ")";
$CREATE[] = $in;
unset($in);

// $oSQL->makeConn("main");
$oSQL->makeConn("local");
for($count = 0; $count < count($CREATE); $count++) {
    $current = $CREATE[$count];
    echo "try to create '" . $current['table'] . " - \n";
    $oSQL->makeQuery($current['sql']);
    echo " OK <br>\n";
}

foreach($CREATE as $current) {
    if(!$oSQL->checkIfTableExists($current['table'])) {
        echo "failure for '" . $current['table']."'<br>";
        exit;
    } else {
        echo "table '" . $current['table']."' exists<br>";
    }
}
echo "success";
?>