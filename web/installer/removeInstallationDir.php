<?php
/*
 * removeInstallationDir.php
 *
 * author: klaus
 *
 * created: 27.05.2018
 * changed: 27.05.2018
 *
 */


@define("DS", DIRECTORY_SEPARATOR);
require_once(dirname(__FILE__).DS."..".DS."main".DS."baseStart.inc.php");

if(file_exists(dirname(__FILE__).DS."installationOK.txt")) {
    if(file_exists(dirname(__FILE__))) {
        $files = @scandir(dirname(__FILE__));
        foreach($files as $file) {
            if($file != "." && $file != "..") {
                echo "removing '" . $file . "'\n";
                unlink(dirname(__FILE__).DS.$file);
            }
        }
        echo "removing installation dir\n";
        rmdir(dirname(__FILE__));
    }
}
