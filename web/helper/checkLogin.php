<?php
/**
 *
 * checkLogin.php
 *
 * author : piwi
 *
 * created: 07.01.2017
 * changed: 07.01.2017
 *
 * purpose:
 *
 */

session_start();
$_SESSION['AUTH']  = false;
$_SESSION['ADMIN'] = false;
if($_POST['loginName'] == "klaus") {
    if($_POST['loginPass'] == "Ws57Adu9") {
        $_SESSION['AUTH'] = true;
        $_SESSION['ADMIN'] = true;
        echo "success";
        exit;
    }
}
if($_POST['loginName'] == "rolf") {
    if($_POST['loginPass'] == "sUpermaNn!55") {
        $_SESSION['AUTH'] = true;
        $_SESSION['RELATED_EMAIL_ID'] = 1;
        echo "success";
        exit;
    }
}
echo "failed";