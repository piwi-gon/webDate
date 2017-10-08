<?php
/**
 *
 * mysql.inc.php
 *
 * author : piwi
 *
 * created: 06.11.2016
 * changed: 06.11.2016
 *
 * purpose:
 *
 */


class cMySQLi {

    private $_sqlObj;
    private $_result;
    private $_dbVars;

    public function __construct() {
        $this->_initDBVars();
    }

    public function insertId() {
        return $this->_sqlObj->insert_id;
    }

    public function checkIfTableExists($tableName) {
        if(!is_object($this->_sqlObj)) {
            echo "<pre>";
            echo "No Conenction possible\n";
            echo "</pre>";
            exit;
        }
        $result = $this->_sqlObj->query("SHOW TABLES LIKE '".$tableName."'");
        $finfo = $result->fetch_fields();
        while($row = $result->fetch_array(MYSQLI_BOTH)) {
            if(isset($resRow)) { unset($resRow); }
            foreach($finfo as $field) {
                $resRow[$field->name] = $row[$field->name];
            }
            $retArray[] = $resRow;
        }
        return count($retArray)>0 ? true : false;
    }

    public function makeConn($index) {
        if($this->_dbVars[$index]['dbHost'] != "" && $this->_dbVars[$index]['dbUser'] != "") {
            $this->_sqlObj = new mysqli($this->_dbVars[$index]['dbHost'], $this->_dbVars[$index]['dbUser'], $this->_dbVars[$index]['dbPass'], $this->_dbVars[$index]['dbName']);
        } else {
            echo "<pre>";
            echo "No Conenction possible\n";
            echo "Index: ".$index."\n";
            echo "Vars\n";
            echo $this->_dbVars[$index]['dbHost']."\n";
            echo "</pre>";
            exit;
        }
    }

    public function makeQuery($sql, $additional="") {
        $checkStr = substr(strtoupper($sql), 0, 6);
        if($checkStr == "SELECT") {
            if(!$result = $this->_sqlObj->query($sql)) {
                echo "<pre>";
                echo "Sorry, the website is experiencing problems.\n";
                echo "Error: Our query failed to execute and here is why: \n";
                echo "Query: " . $sql . "\n";
                echo "Errno: " . $this->_sqlObj->errno . "\n";
                echo "Error: " . $this->_sqlObj->error . "\n";
                echo "</pre>";
                exit;
            }
            $finfo = $result->fetch_fields();
            while($row = $result->fetch_array(MYSQLI_BOTH)) {
                if(isset($resRow)) { unset($resRow); }
                foreach($finfo as $field) {
                    $resRow[$field->name] = iconv("iso-8859-1", "utf-8", $row[$field->name]);
                }
                $retArray[] = $resRow;
            }
            return $retArray;
        } else {
            if($this->_sqlObj->query($sql)!==true) {
                echo "<pre>";
                echo "Sorry, the website is experiencing problems.\n";
                echo "Error: Our query failed to execute and here is why: \n";
                echo "Query: " . $sql . "\n";
                echo "Errno: " . $this->_sqlObj->errno . "\n";
                echo "Error: " . $this->_sqlObj->error . "\n";
                echo "</pre>";
                exit;
            }
            return;
        }
    }

    public function escapeString($string) {
        if(!is_object($this->_sqlObj)) { $this->makeConn("local"); }
        $ret = $this->_sqlObj->real_escape_string($string);
        return $ret;
    }

    private function _initDBVars() {
        include(dirname(__FILE__).DIRECTORY_SEPARATOR."lib".DIRECTORY_SEPARATOR."dbVars.inc.php");
        $dbKeys    = array_keys($DBHost);
        $numOfKeys = count($dbKeys);
        for($count = 0; $count < $numOfKeys; $count++) {
            $this->_dbVars[$dbKeys[$count]]['dbHost'] = $DBHost[$dbKeys[$count]];
            $this->_dbVars[$dbKeys[$count]]['dbName'] = $DBName[$dbKeys[$count]];
            $this->_dbVars[$dbKeys[$count]]['dbUser'] = $DBUser[$dbKeys[$count]];
            $this->_dbVars[$dbKeys[$count]]['dbPass'] = $DBPass[$dbKeys[$count]];
        }
    }
}