<?php
/**
 *
 * clistart.inc.php
 *
 * author : piwi
 *
 * created: 02.11.2016
 * changed: 02.11.2016
 *
 * purpose:
 *
 */

// function checkInstallation() {
//     global $DBName, $mysqlObj;
//     if(!checkIfTableExists("Recipients", $DBName)) {
//         if(!is_object($mysqlObj)) { connectToMySQL(); }
//         if(!is_object($mysqlObj)) { echo "Sorry - not SQL-Object could be initialised"; exit(); }
//         $sql = "CREATE TABLE IF NOT EXISTS Recipients(Recipients_id int auto_increment primary key, recipient_name VARCHAR(200) DEFAULT '' NOT NULL, recpient_address VARCHAR(255) DEFAULT '' NOT NULL)";
//         if(!$result = $mysqlObj->query($sql)) {
//             echo "<pre>";
//             echo "Sorry, the website is experiencing problems.";
//             echo "Error: Our query failed to execute and here is why: \n";
//             echo "Query: " . $sql . "\n";
//             echo "Errno: " . $mysqli->errno . "\n";
//             echo "Error: " . $mysqli->error . "\n";
//             echo "</pre>";
//             exit;
//         }
//     }
// }

// function checkIfTableExists($TableName, $DBName) {
//     global $mysqlObj;
//     if(!is_object($mysqlObj)) { connectToMySQL(); }
//     if(!is_object($mysqlObj)) { echo "Sorry - not SQL-Object could be initialised"; exit(); }
//     $sql = "SELECT COUNT(*) FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '".$DBName."' AND TABLE_NAME = '".$TableName."'";
//     $result = $mysqlObj->query($sql);
//     return mysqli_num_rows($result)>0 ? true : false;
// }

class cWebDateSOAP {

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

    public function queryRecipients() {
        $sql = "select * from t_recipient "; // where active = 1";
        if (isset($this->_soapParams)) {
            unset($this->_soapParams);
        }
        $this->_soapParams[] = new SoapParam($sql, "sql");
        $retArray = $this->_doCall();
        return $retArray;
    }

    public function queryCalendarData($recipientId = "") {
        // @formatter:off
        $sql = "select * from r_schedule_recipient as a ".
                "left join t_schedule as b on a.fk_schedule_id = b.schedule_id ".
                "where day = '".date('d')."' and ".
                "month = '".date('m')."' ".
                "and fk_recipient_id = '" . $recipientId . "'";
        // @formatter:on
        $this->_soapParams[] = new SoapParam($sql, "sql");
        $retArray = $this->_doCall();
        return $retArray;
    }

    private function _doCall() {
        $this->_SOAPAction = "queryDB";
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