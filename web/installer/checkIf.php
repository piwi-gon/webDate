<?php
/*
 * checkIf.php
 *
 * author: klaus
 *
 * created: 06.05.2018
 * changed: 06.05.2018
 *
 */

$checkExtension = filter_input(INPUT_GET, $_GET['checkExtension']);
$isWritable     = filter_input(INPUT_GET, $_GET['checkIsWriteable']);
if($checkExtension != "") {
    switch($checkExtension) {
        case "mysqli" : $result = checkMySQLI();   break;
    }
    if($result) {
        echo "success";
        exit;
    }
    echo "failed";
    exit;
} else if($isWritable=="true") {
    if(is_writable(dirname(__FILE__)."/../main/classes/lib/")) {
        return "success";
        exit;
    }
    echo "failed";
    exit;
} else {
    $checkPHPVersion = filter_input(INPUT_GET, $_GET['checkPHPVersion']);
    if(version_compare(PHP_VERSION, $checkPHPVersion, ">=")) {
        echo "success";
        exit;
    }
    echo "failed";
    exit;
}

// Functions

function checkMySQLi() {
    if(function_exists("mysqli_connect")) {
        return true;
    }
    return false;
}