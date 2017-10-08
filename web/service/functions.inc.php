<?php
/**
 *
 * functions.inc.php
 *
 * author : piwi
 *
 * created: 28.12.2014
 * changed: 28.12.2014
 *
 * purpose: includes the ptfw-manager-class
 *
 */


class cPTFWManager {

    private $_sql;

    private $_auth;
    private $_loginName;
    private $_loginpass;

    public function __construct() {
        global $oSQL;
        $this->_sql = $oSQL;
    }

    public function Authenticate($args) {
        $fp = fopen(dirname(__FILE__).DIRECTORY_SEPARATOR."logintest.log");
        fwrite($fp, "Prove Login\n");
        if($args->userName != "") {
            $this->_loginName = $args->userName;
            $this->_loginPass = $args->userPass;
            fwrite($fp, "LN: " . $args->userName." - PW: " . $args->userPass . "\n");
            if($args->userName == "WD_Manager") {
                if($args->userPass == "KIo)9!4Grs") {
                    $this->_auth = true;
                } else {
                    $this->_auth = false;
                }
            } else {
                    $this->_auth = false;
            }
        } else {
            $this->_auth = false;
        }
        if($fp != null) { fclose($fp); }
        return $this->_auth;
    }

    public function openDB() {
        if(!$this->_auth){ return $this->_wrongUserName(); }
        $this->_sql->makeConn("main");
    }

    public function queryDB($sql) {
        if(!$this->_auth){ return $this->_wrongUserName(); }
        $this->_sql->makeConn("main");
        $result = $this->_sql->makeQuery($sql);
        return $result;
    }

    public function getInsertId() {
        if(!$this->_auth){ return $this->_wrongUserName(); }
        return $this->_sql->insertId();
    }

    public function escapeString($string) {
        if(!$this->_auth){ return $this->_wrongUserName(); }
        $this->_sql->makeConn("main");
        return $this->_sql->escapeString($string);
    }

    private function _wrongUserName() {
        return new nusoap_fault("SOAP-ENV:Client", "", "Invalid Username/Password (used: '" . $this->_loginName . "/".$this->_loginPass."')");
    }
}
?>