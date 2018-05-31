<?php
/*
 * saveDatabaseConnection.php
 *
 * author: klaus
 *
 * created: 21.05.2018
 * changed: 21.05.2018
 *
 */


@define("DS", DIRECTORY_SEPARATOR);
$dbHost =filter_input(INPUT_POST, "dbHost");
$dbName =filter_input(INPUT_POST, "dbName");
$dbUser =filter_input(INPUT_POST, "dbUser");
$dbPass =filter_input(INPUT_POST, "dbPass");
$dbPassWH =filter_input(INPUT_POST, "dbPass_WH");
if($dbPass == $dbPassWH) {
    $dbFileContent = "<?php\n".
            "/**\n".
            " *\n".
            " * dbVars.inc.php\n".
            " *\n".
            " * author : piwi\n".
            " *\n".
            " * created: 04.11.2016\n".
            " * changed: 04.11.2016\n".
            " *\n".
            " * purpose:\n".
            " *\n".
            " */\n".
            " \n".
            "\$DBHost['main'] = \"".$dbHost."\";\n".
            "\$DBName['main'] = \"".$dbName."\";\n".
            "\$DBUser['main'] = \"".$dbUser."\";\n".
            "\$DBPass['main'] = \"".$dbPass."\";\n".
            "?>";
    file_put_contents(dirname(__FILE__).DS."..".DS."main".DS."classes".DS."lib".DS."dbVars.inc.php", $dbFileContent);
    $mysqli = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
    if($mysqli->errno) {
        echo "failed (" . $mysqli->errno . ") " . $mysqli->error;;
    } else {
        $content = file_get_contents(dirname(__FILE__).DS."databaseStruct.php");
        $lines = explode("\n", $content);
        foreach($lines as $line) {
            if(!startsWith($line, array("/", "*", "<?", "?>", "--")) && $line!="") {
                if(substr($line, -1)==";") {
                    $sqlContent .= $line;
                    $sql[] = $sqlContent;
                    $sqlContent="";
                } else {
                    $sqlContent .= $line;
                }
            }
        }
        foreach($sql as $row) {
            // echo "executing '" . $row . "'\n";
            if(!$mysqli->query($row)) {
                echo "failed  (" . $mysqli->errno . ") " . $mysqli->error;
                $mysqli->close($connection);
                $flag=false;
                exit;
            } else {
                $flag = true;
            }
        }
        if($flag) {
            echo "success";
        } else {
            echo "failed";
        }
    }
} else {
    echo "failed (" . $mysqli->errno . ") " . $mysqli->error;;
}
exit;

function startsWith($string, $filter) {
    $retFlag = false;
    if(is_array($filter)) {
        foreach($filter as $fi) {
            if(substr(trim($string), 0, strlen($fi)) == $fi) {
                $retFlag = true;
            }
        }
    } else {
        if(substr(trim($string), 0, strlen($filter)) == $filter) {
            $retFlag = true;
        }
    }
    return $retFlag;
}
?>