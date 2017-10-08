<?php
/**
 *
 * cWebDate.inc.php
 *
 * author : piwi
 *
 * created: 07.01.2017
 * changed: 07.01.2017
 *
 * purpose:
 *
 */
class cWebDate {

    private $_sqlObj;
    private $_soapParams;
    private $_endPoint;
    private $_soapClient;
    private $_SOAPAction;
    private $_additionalHeader;

    public function __construct() {
        global $oSQL;
        $this->_sqlObj = $oSQL;
        $this->_endPoint = "http://www.wondernet24.de/webdate/service/server.php";
    }

    public function correct() {
        $sql = "update t_schedule set single_message = 1 where year > 0";
        if (isset($this->_soapParams)) {
            unset($this->_soapParams);
        }
        $this->_soapParams[] = new SoapParam($sql, "sql");
        $this->_doCall();
    }

    public function relate() {
        $recipientId = 1;
        $data = $this->queryAllDataWithoutRecipient();
        foreach ( $data as $row ) {
            // @formatter:off
            $sql = "insert into r_schedule_recipient (fk_schedule_id, fk_recipient_id) " .
                   "VALUES('" . $row['schedule_id'] . "', '" . $recipientId . "')";
            // @formatter:on
            if (isset($this->_soapParams)) {
                unset($this->_soapParams);
            }
            $this->_soapParams[] = new SoapParam($sql, "sql");
            $this->_doCall();
        }
    }

    public function queryAllDataWithoutRecipient() {
        $sql = "select * from t_schedule";
        if (isset($this->_soapParams)) {
            unset($this->_soapParams);
        }
        $this->_soapParams[] = new SoapParam($sql, "sql");
        $retArray = $this->_doCall();
        return $retArray;
    }

    public function queryAllData($recipientId, $month = "") {
        // @formatter:off
        $sql = "select * from t_schedule as a " .
               "left join r_schedule_recipient as b on a.schedule_id = b.fk_schedule_id " .
               "left join t_recipient as c on b.fk_recipient_id = c.recipient_id ".
               "where fk_recipient_id = '" . $recipientId . "'";
        // @formatter:on
        if ($month != "") {
            $sql .= " and month = '" . $month . "' order by month, day";
        }
        if (isset($this->_soapParams)) {
            unset($this->_soapParams);
        }
        $this->_soapParams[] = new SoapParam($sql, "sql");
        $retArray = $this->_doCall();
        return $retArray;
    }

    public function queryData() {
        // @formatter:off
        $sql = "select * from t_schedule as a ".
               "left join r_schedule_recipient as b on a.schedule_id = b.fk_schedule_id " .
               "left join t_recipient as c on b.fk_recipient_id = c.recipient_id";
        // @formatter:on
        if (isset($this->_soapParams)) {
            unset($this->_soapParams);
        }
        $this->_soapParams[] = new SoapParam($sql, "sql");
        $retArray = $this->_doCall();
        return $retArray;
    }

    public function queryEntry($selectedEntry) {
        // @formatter:off
        $sql = "select * from t_schedule as a " .
               "left join r_schedule_recipient as b on a.schedule_id = b.fk_schedule_id " .
               "left join t_recipient as c on b.fk_recipient_id = c.recipient_id " .
               "where schedule_id = '" . $selectedEntry . "'";
        // @formatter:on
        if (isset($this->_soapParams)) {
            unset($this->_soapParams);
        }
        $this->_soapParams[] = new SoapParam($sql, "sql");
        $retArray = $this->_doCall();
        return $retArray[0];
    }

    public function queryRelation() {
        $sql = "select * from r_schedule_recipient";
        if (isset($this->_soapParams)) {
            unset($this->_soapParams);
        }
        $this->_soapParams[] = new SoapParam($sql, "sql");
        $retArray = $this->_doCall();
        return $retArray;
    }

    public function queryRecipients() {
        $sql = "select * from t_recipient"; // where active = 1";
        if (isset($this->_soapParams)) {
            unset($this->_soapParams);
        }
        $this->_soapParams[] = new SoapParam($sql, "sql");
        $retArray = $this->_doCall();
        return $retArray;
    }

    public function queryRecipient($recipientId) {
        $sql = "select * from t_recipient where recipient_id = '" . $recipientIds . "'";
        if (isset($this->_soapParams)) {
            unset($this->_soapParams);
        }
        $this->_soapParams[] = new SoapParam($sql, "sql");
        $retArray = $this->_doCall();
        return $retArray;
    }

    public function saveEntry($VAR) {
        if (intval($VAR['selectedScheduleEntry']) > 0) {
            $this->_updateEntry($VAR);
        } else {
            $this->_insertEntry($VAR);
        }
    }

    public function addScheduleEntry($message, $day, $month, $year, $recipientId) {
        // @formatter:off
        $insert = "insert into t_schedule (message, day, month, year, single_message, is_used) " .
                  "VALUES('" . $this->_escapeString($message) . "', " .
                  "'" . $this->_escapeString($day) . "', " .
                  "'" . $this->_escapeString($month) . "', " .
                  "'" . $this->_escapeString($year) . "', " .
                  "'" . (($year == "") ? "1" : "0") . "', " .
                  "'" . "0" . "')";
        // @formatter:on
        if (isset($this->_soapParams)) {
            unset($this->_soapParams);
        }
        $this->_soapParams[] = new SoapParam($insert, "sql");
        $this->_doCall();
        $insertId = $this->_doCallInsertId();
        $this->_relateMessageToRecipient($insertId, $recipientId);
    }

    public function addRecipient($name, $address) {
        $result = $this->_checkAddress($address);
        if ($result == 0) {
            // @formatter:off
            $insert = "insert into t_recipient (recipient_name, recipient_address) " .
                      "VALUES('" . $this->_escapeString($name) . "', '" . $this->_escapeString($address) . "')";
            // @formatter:on
            if (isset($this->_soapParams)) {
                unset($this->_soapParams);
            }
            error_log("SQL: " . $sql . "\n", 3, "/tmp/sqlWebDate.log");
            $this->_soapParams[] = new SoapParam($insert, "sql");
            // $this->_doCall();
            return $insertId = $this->_doCallInsertId();
        }
        return $result;
    }

    private function _insertEntry($VAR) {
        list($year, $month, $day) = explode("-", $VAR['scheduleDateISO']);
        // @formatter:off
        $insert = "insert into t_schedule (month, day, year, message, single_message) " .
                  "VALUES('" . $this->_escapeString($day) . "', " .
                  "'" . $this->_escapeString($month) . "', " .
                  "'" . $this->_escapeString($year) . "', " .
                  "'" . $this->_escapeString($VAR['scheduleMessage']) . "', ".
                  "'" . (isset($VAR['scheduleIsPeriodic']) ? "1" : "0") . "')";
        // @formatter:on
        if (isset($this->_soapParams)) {
            unset($this->_soapParams);
        }
        $this->_soapParams[] = new SoapParam($insert, "sql");
        $this->_doCall();
    }

    private function _updateEntry($VAR) {
        if ($VAR['deleteEntry'] == "true") {
            // @formatter:off
            $query = "delete from t_schedule ".
                     "where schedule_id = '" . $this->_escapeString($VAR['selectedScheduleEntry']) . "'";
            // @formatter:on
        } else {
            list($year, $month, $day) = explode("-", $VAR['scheduleDateISO']);
            // @formatter:off
            $query = "update t_schedule " .
                     "set day = '" . $this->_escapeString($day) . "', " .
                     "month = '" . $this->_escapeString($month) . "', " .
                     "year = '" . $this->_escapeString($year) . "', " .
                     "single_message = '" . (isset($VAR['scheduleIsPeriodic']) ? "0" : "1") . "', " .
                     "message = '" . $this->_escapeString($VAR['scheduleMessage']) . "' " .
                     "where schedule_id = '" . $this->_escapeString($VAR['selectedScheduleEntry']) . "'";
            // @formatter:on
        }
        if (isset($this->_soapParams)) {
            unset($this->_soapParams);
        }
        $this->_soapParams[] = new SoapParam($query, "sql");
        $retArray = $this->_doCall();
    }

    private function _checkAddress($address) {
        // @formatter:off
        $select = "select recipient_id from t_recipient " .
                  "where recipient_address = '" . $this->_escapeString($address) . "'";
        // @formatter:on
        if (isset($this->_soapParams)) {
            unset($this->_soapParams);
        }
        $this->_soapParams[] = new SoapParam($select, "sql");
        $retArray = $this->_doCall();
        return intval($retArray[0]['recipient_id']);
    }

    private function _relateMessageToRecipient($insertId, $recipientId) {
        // @formatter:off
        $insert = "insert into r_schedule_recipient " . "(fk_schedule_id, fk_recipient_id) " .
                  "VALUES('" . $insertId . "', '" . $recipientId . "')";
        // @formatter:on
        if (isset($this->_soapParams)) {
            unset($this->_soapParams);
        }
        $this->_soapParams[] = new SoapParam($insert, "sql");
        $retArray = $this->_doCall();
    }

    public function _deleteEntry($selectedEntry) {
        // @formatter:off
        $sql = "delete from t_schedule " .
               "where schedule_id = '" . $selectedEntry . "'";
        // @formatter:on
        if (isset($this->_soapParams)) {
            unset($this->_soapParams);
        }
        echo $sql;
//         $this->_soapParams[] = new SoapParam($sql, "sql");
//         $retArray = $this->_doCall();
        return $retArray[0];
    }

    private function _doCall() {
        $this->_SOAPAction = "queryDB";
        return $this->_doSOAPCall();
    }

    private function _escapeString($string) {
        if (isset($this->_soapParams)) {
            unset($this->_soapParams);
        }
        $this->_soapParams[] = new SoapParam($string, "string");
        return $this->_doEscapeString();
    }

    private function _doEscapeString() {
        $this->_SOAPAction = "escapeString";
        return $this->_doSOAPCall();
    }

    private function _doCallInsertId() {
        $this->_SOAPAction = "getInsertId";
        return $this->_doSOAPCall();
    }

    private function _doSOAPCall() {
        $WSDL = $this->_endPoint . "?wsdl";
        $options = array("location" => $this->_endPoint,"uri" => "urn:testapi","style" => SOAP_RPC,"use" => SOAP_ENCODED,"trace" => 1,"cache_wsdl" => WSDL_CACHE_NONE
        );
        try {
            $this->_createAuthenticationHeader();
            $SOAPClient = new SoapClient($WSDL, $options);
            $SOAPClient->__setSoapHeaders($this->_additionalHeader);
            $result = $SOAPClient->__soapCall($this->_SOAPAction, $this->_soapParams);
            return $result;
        } catch ( Exception $ex ) {
            echo "<pre>";
            echo "Functions are (URL: " . $this->_endPoint . "): <br>";
            print_r($SOAPClient->__getFunctions());
            echo html_entity_decode($SOAPClient->__getLastRequest());
            echo html_entity_decode($SOAPClient->__getLastResponse());
            echo $ex->getMessage() . "<br>";
            echo "</pre>";
            die("no connection in success");
            exit();
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