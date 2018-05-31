<?php
/*
 * checkDatabaseConnection.php
 *
 * author: klaus
 *
 * created: 13.05.2018
 * changed: 13.05.2018
 *
 */

if($_POST['dbHost'] != "" && $_POST['dbName'] != "" && $_POST['dbUser'] != "") {
    /**
     * check database-connection with given parameters
     */
    $dbHost =filter_input(INPUT_POST, "dbHost");
    $dbName =filter_input(INPUT_POST, "dbName");
    $dbUser =filter_input(INPUT_POST, "dbUser");
    $dbPass =filter_input(INPUT_POST, "dbPass");
    $dbPassWH =filter_input(INPUT_POST, "dbPass_WH");
    if($dbPass == $dbPassWH) {
        $connection = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
        if($connection != null) {
            mysqli_close($connection);
            echo "success";
            exit;
        }
    } else {
        echo "failed";
    }
    exit;
} else {
    echo "failed";
    exit;
}
?>