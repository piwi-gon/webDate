<?php
/**
 *
 * WebDate.inc.php
 *
 * author : piwi
 *
 * created: 04.11.2016
 * changed: 04.11.2016
 *
 * purpose:
 *
 */

$mainDir = dirname(__FILE__);

class WebDateMigration {

    private $_sqlObj;
    private $_soapParams;

    private $_endPoint;
    private $_soapClient;

    private $_SOAPAction;

    private $_additionalHeader;

    public function __construct() {
        global $oSQL;
        $this->_sqlObj = $oSQL;
        $this->_endPoint = "https://www.wondernet24.de/webdate/service/server.php";
    }

    public function truncateOldData() {
        $sql = "truncate r_schedule_recipient";
        if(isset($this->_soapParams)) { unset($this->_soapParams); }
        $this->_soapParams[] = new SoapParam($sql, "sql");
        $retArray = $this->_doCall();
        $sql = "truncate t_recipient";
        if(isset($this->_soapParams)) { unset($this->_soapParams); }
        $this->_soapParams[] = new SoapParam($sql, "sql");
        $retArray = $this->_doCall();
        $sql = "truncate t_schedule";
        if(isset($this->_soapParams)) { unset($this->_soapParams); }
        $this->_soapParams[] = new SoapParam($sql, "sql");
        $retArray = $this->_doCall();
    }

    public function queryAllData($month="") {
        $sql = "select * from WebDate";
        if($month != "") { $sql .= " where Monat = '".$month."' order by Monat, Tag"; }
        if(isset($this->_soapParams)) { unset($this->_soapParams); }
        $this->_soapParams[] = new SoapParam($sql, "sql");
        $retArray = $this->_doCall();
        return $retArray;
    }

    public function queryAllDataNew($month="") {
        $sql = "select * from t_schedule";
        if($month != "") { $sql .= " where month = '".$month."' order by month, day"; }
//         $sql = "select * from t_recipient";
        if(isset($this->_soapParams)) { unset($this->_soapParams); }
        $this->_soapParams[] = new SoapParam($sql, "sql");
        $retArray = $this->_doCall();
        return $retArray;
    }

    public function queryEntry($selectedEntry) {
        $sql = "select * from WebDate where IdentNr = '" . $selectedEntry . "'";
        if(isset($this->_soapParams)) { unset($this->_soapParams); }
        $this->_soapParams[] = new SoapParam($sql, "sql");
        $retArray = $this->_doCall();
        return $retArray[0];
    }

    public function queryRecipients() {
        $sql = "select * from t_recipient where active = 1";
        if(isset($this->_soapParams)) { unset($this->_soapParams); }
        $this->_soapParams[] = new SoapParam($sql, "sql");
        $retArray = $this->_doCall();
        return $retArray;
    }

    public function saveEntry($VAR) {
        if(intval($VAR['selectedScheduleEntry'])>0) {
            $this->_updateEntry($VAR);
        } else {
            $this->_insertEntry($VAR);
        }
    }

    public function addScheduleEntry($message, $day, $month, $year, $recipientId) {
        $insert = "insert into t_schedule (message, day, month, year, single_message, is_used) ".
                  "VALUES('" . $this->_sqlObj->escapeString($message) . "', ".
                  "'" . $this->_sqlObj->escapeString($day) . "', ".
                  "'" . $this->_sqlObj->escapeString($month) . "', ".
                  "'" . $this->_sqlObj->escapeString($year) . "', ".
                  "'" . (($year == "") ? "1" : "0") . "', ".
                  "'" . "0" . "')";
        if(isset($this->_soapParams)) { unset($this->_soapParams); }
        $this->_soapParams[] = new SoapParam($insert, "sql");
        $this->_doCall();
        $insertId = $this->_doCallInsertId();
        $this->_relateMessageToRecipient($insertId, $recipientId);
    }

    public function addRecipient($name, $address) {
        $result = $this->_checkAddress($address);
        if($result == 0) {
            $insert = "insert into t_recipient (recipient_name, recipient_address) ".
                      "VALUES('".$this->_sqlObj->escapeString($name)."', '".$this->_sqlObj->escapeString($address)."')";
            if(isset($this->_soapParams)) { unset($this->_soapParams); }
            $this->_soapParams[] = new SoapParam($insert, "sql");
            $this->_doCall();
            return $insertId = $this->_doCallInsertId();
        }
        return $result;
    }

    private function _insertEntry($VAR) {
        list($year, $month, $day) = explode("-", $VAR['scheduleDateISO']);
        if($VAR['isPeriodic'] == "true") { $year = ""; }
        $insert = "insert into WebDate (Monat, Tag, Jahr, Nachricht) ".
                  "VALUES('" . $this->_sqlObj->escapeString($day) . "', ".
                  "'" . $this->_sqlObj->escapeString($month) . "', ".
                  "'" . $this->_sqlObj->escapeString($year) . "', ".
                  "'" . $this->_sqlObj->escapeString($VAR['scheduleMessage']) . "')";
        if(isset($this->_soapParams)) { unset($this->_soapParams); }
        $this->_soapParams[] = new SoapParam($insert, "sql");
        $this->_doCall();
    }

    private function _updateEntry($VAR) {
        if($VAR['deleteEntry'] == "true") {
            $query  = "delete from Webdate where IdentNr = '" . $this->_sqlObj->escapeString($VAR['selectedScheduleEntry']) . "'";
        } else {
            list($year, $month, $day) = explode("-", $VAR['scheduleDateISO']);
            if($VAR['isPeriodic'] == "true") { $year = ""; }
            $query  = "update WebDate ".
                      "set Tag = '" . $this->_sqlObj->escapeString($day) . "', ".
                      "Monat = '" . $this->_sqlObj->escapeString($month) . "', ".
                      "Jahr = '" . $this->_sqlObj->escapeString($year) . "', ".
                      "Nachricht = '" . $this->_sqlObj->escapeString($VAR['scheduleMessage']) . "' ".
                      "where IdentNr = '" . $this->_sqlObj->escapeString($VAR['selectedScheduleEntry']) . "'";
        }
        if(isset($this->_soapParams)) { unset($this->_soapParams); }
        $this->_soapParams[] = new SoapParam($query, "sql");
        $retArray = $this->_doCall();
    }

    private function _checkAddress($address) {
        $select = "select recipient_id from t_recipient ".
                  "where recipient_address = '" . $this->_sqlObj->escapeString($address) . "'";
        if(isset($this->_soapParams)) { unset($this->_soapParams); }
        $this->_soapParams[] = new SoapParam($select, "sql");
        $retArray = $this->_doCall();
        return intval($retArray[0]['recipient_id']);
    }

    private function _relateMessageToRecipient($insertId, $recipientId) {
        $insert = "insert into r_schedule_recipient ".
                  "(fk_schedule_id, fk_recipient_id) ".
                  "VALUES('" . $insertId . "', '". $recipientId . "')";
        if(isset($this->_soapParams)) { unset($this->_soapParams); }
        $this->_soapParams[] = new SoapParam($insert, "sql");
        $retArray = $this->_doCall();
    }

    private function _doCall() {
        $this->_SOAPAction = "queryDB";
        return $this->_doSOAPCall();
    }

    private function _doCallInsertId() {
        $this->_SOAPAction = "getInsertId";
        return $this->_doSOAPCall();
    }

    private function _doSOAPCall() {
        $WSDL       = $this->_endPoint . "?wsdl";
        $options    = array("location"=> $this->_endPoint,
                        "uri"         => "urn:testapi",
                        "style"       =>  SOAP_RPC,
                        "use"         =>  SOAP_ENCODED,
                        "trace"       => 1,
                        "cache_wsdl"  =>  WSDL_CACHE_NONE);
        try {
            $this->_createAuthenticationHeader();
            $SOAPClient = new SoapClient($WSDL, $options);
            $SOAPClient->__setSoapHeaders($this->_additionalHeader);
            $result = $SOAPClient->__soapCall($this->_SOAPAction, $this->_soapParams);
            return $result;
        } catch(Exception $ex) {
            echo "<pre>";
            echo "Functions are (URL: " . $this->_endPoint . "): <br>";
            print_r($SOAPClient->__getFunctions());
            echo html_entity_decode($SOAPClient->__getLastRequest());
            echo html_entity_decode($SOAPClient->__getLastResponse());
            echo $ex->getMessage()."<br>";
            echo "</pre>";
            die("no connection in success");
            exit;
        }

    }

    private function _createAuthenticationHeader() {
        $auth = new stdClass();
        $auth->userName = "WD_Manager";
        $auth->userPass = "KIo)9!4Grs";
        $authVal = new SoapVar($auth, SOAP_ENC_OBJECT);
        $this->_additionalHeader = new SoapHeader("urn:testapi", "Authenticate", $authVal, false);
    }
}
?>