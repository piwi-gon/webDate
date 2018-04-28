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

include_once(dirname(__FILE__).DS."options".DS."tWebDateOptions.inc.php");

class cWebDate {

    use tWebdateOptions;

    private $_sqlObj;

    public function __construct() {
        global $oSQL;
        $this->_sqlObj = $oSQL;
    }

    public function correct() {
        $sql = "update t_schedule set single_message = 1 where year > 0";
        $this->_sqlObj->makeConn("main");
        $this->_sqlObj->makeQuery($sql);
    }

    public function relate() {
        $recipientId = 1;
        $data = $this->queryAllDataWithoutRecipient();
        foreach ( $data as $row ) {
            // @formatter:off
            $sql = "insert into r_schedule_recipient (fk_schedule_id, fk_recipient_id) " .
                   "VALUES('" . $row['schedule_id'] . "', '" . $recipientId . "')";
            // @formatter:on
            $this->_sqlObj->makeConn("main");
            $this->_sqlObj->makeQuery($sql);
        }
    }

    public function queryAllDataWithoutRecipient() {
        $sql = "select * from t_schedule";
        $this->_sqlObj->makeConn("main");
        $result = $this->_sqlObj->makeQuery($sql);
        return $result;
    }

    /**
     * this function queries all calendar-data for current date
     *
     * @param string $recipientId
     * @return void|string
     */
    public function queryCalendarData($recipientId = "") {
        // @formatter:off
        $sql = "select * from r_schedule_recipient as a ".
                "left join t_schedule as b on a.fk_schedule_id = b.schedule_id ".
                "where day = '".date('d')."' and ".
                "month = '".date('m')."' ".
                "and is_used = false ".
                "and fk_recipient_id = '" . $recipientId . "'";
        // @formatter:on
        $this->_sqlObj->makeConn("main");
        $result = $this->_sqlObj->makeQuery($sql);
        return $result;
    }

    public function queryAllData($recipientId, $month = "") {
        // @formatter:off
        $sql = "select * from t_schedule as a " .
               "left join r_schedule_recipient as b on a.schedule_id = b.fk_schedule_id " .
               "left join t_recipient as c on b.fk_recipient_id = c.recipient_id ".
               "where fk_recipient_id = '" . $recipientId . "'";
        if ($month != "") {
            $sql .= " and month = '" . $month . "' order by month, day";
        }
        // @formatter:on
        $this->_sqlObj->makeConn("main");
        $result = $this->_sqlObj->makeQuery($sql);
        return $result;
    }

    public function queryData() {
        // @formatter:off
        $sql = "select * from t_schedule as a ".
               "left join r_schedule_recipient as b on a.schedule_id = b.fk_schedule_id " .
               "left join t_recipient as c on b.fk_recipient_id = c.recipient_id";
        // @formatter:on
        $this->_sqlObj->makeConn("main");
        $result = $this->_sqlObj->makeQuery($sql);
        return $result;
    }

    public function queryEntry($selectedEntry) {
        // @formatter:off
        $sql = "select * from t_schedule as a " .
               "left join r_schedule_recipient as b on a.schedule_id = b.fk_schedule_id " .
               "left join t_recipient as c on b.fk_recipient_id = c.recipient_id " .
               "where schedule_id = '" . $selectedEntry . "'";
        // @formatter:on
        $this->_sqlObj->makeConn("main");
        $result = $this->_sqlObj->makeQuery($sql);
        return $result[0];
    }

    public function queryRelation() {
        $sql = "select * from r_schedule_recipient";
        $this->_sqlObj->makeConn("main");
        $result = $this->_sqlObj->makeQuery($sql);
        return $result;
    }

    public function queryRecipients() {
        $sql = "select * from t_recipient"; // where active = 1";
        $this->_sqlObj->makeConn("main");
        $result = $this->_sqlObj->makeQuery($sql);
        if(count($result)>0) {
            $return=array();
            foreach($result as $row) {
                $row['recipient_name'] = preg_replace("/<.*?>/", "", $row['recipient_name']);
                $return[] = $row;
            }
            return $return;
        }
        return null;
    }

    public function queryRecipient($recipientId) {
        $sql = "select * from t_recipient where recipient_id = '" . $recipientId . "'";
        $this->_sqlObj->makeConn("main");
        $result = $this->_sqlObj->makeQuery($sql);
        return $result[0];
    }

    public function queryRecipientByLoginId($loginResult) {
        $sql = "select fk_recipient_id from t_login where login_id = '" . $loginResult . "'";
        $this->_sqlObj->makeConn("main");
        $result = $this->_sqlObj->makeQuery($sql);
        return $result[0]['fk_recipient_id'];
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
        $this->_sqlObj->makeConn("main");
        $this->_sqlObj->makeQuery($insert);
        $insertId = $this->_sqlObj->insertId();
        $this->_relateMessageToRecipient($insertId, $recipientId);
    }

    public function addRecipient($VAR) {
        $result = $this->_checkAddress($VAR['emailRecipientAddress']);
        if ($result == 0) {
            // @formatter:off
            $insert = "insert into t_recipient (recipient_name, recipient_address) " .
                    "VALUES('" . $this->_escapeString($VAR['emailRecipientName']) . "', '" . $this->_escapeString($VAR['emailRecipientAddress']) . "')";
            // @formatter:on
            $this->_sqlObj->makeConn("main");
            $this->_sqlObj->makeQuery($insert);
            $insertId = $this->_sqlObj->insertId();
            return $insertId;
        } else {
            // @formatter:off
            $update = "update t_recipient " .
                      "set recipient_name = '" . $this->_escapeString($VAR['emailRecipientName']) . "', ".
                      "recipient_address = '" . $this->_escapeString($VAR['emailRecipientAddress']) . "' ".
                      "where recipient_id = '" . $result . "'";
            // @formatter:on
            $this->_sqlObj->makeConn("main");
            $this->_sqlObj->makeQuery($update);
            return $result;
        }
        return null;
    }

    public function changeRecipientAddress($VAR) {
        // @formatter:off
        $update = "update t_recipient " .
                  "set recipient_name = '" . $this->_escapeString($VAR['newEMailName']) . "', ".
                  "recipient_address = '" . $this->_escapeString($VAR['newEMailAddress']) . "' ".
                  "where recipient_id = '" . $VAR['recipientId'] . "'";
        // @formatter:on
        $this->_sqlObj->makeConn("main");
        $this->_sqlObj->makeQuery($update);
        return 1;
    }

    public function checkAdminRights($loginResult) {
        // @formatter:off
        $select = "select * from t_login as a ".
                "where login_id = '" . $this->_escapeString($loginResult) . "'";
        // @formatter:on
        $this->_sqlObj->makeConn("main");
        $result = $this->_sqlObj->makeQuery($select);
        return ($result[0]['is_admin'] == 1 ? true : false);
    }

    public function checkLoginData($userName, $userPass) {
        // @formatter:off
        $select = "select * from t_login as a ".
                  "where login_name = '" . $this->_escapeString($userName) . "'";
        // @formatter:on
        $this->_sqlObj->makeConn("main");
        $result = $this->_sqlObj->makeQuery($select);
        if($result[0]['login_pass'] == $userPass) {
            return (intval($result[0]['login_id'])>0 ? intval($result[0]['login_id']) : false);
        }
        return false;
    }

    public function changeLoginPassword($LOGINID, $VAR) {
        // @formatter:off
        $select = "select * from t_login where login_id = '" . $LOGINID . "'";
        // @formatter:on
        $this->_sqlObj->makeConn("main");
        $result = $this->_sqlObj->makeQuery($select);
        if($result[0]['login_pass'] == $VAR['currentPassword']) {
            $this->_updateLoginpassword($LOGINID, $VAR['newPassword']);
            return "success";
        } else {
            return "Falsches Passwort";
        }
    }

    public function addLoginData($VAR) {
        $result = $this->_checkLoginName($VAR['emailRecipientUser']);
        if($result == 0) {
            // @formatter:off
            $insert = "insert into t_login (login_name, login_pass, full_name, fk_recipient_id) " .
                    "VALUES('".$this->_escapeString($VAR['emailRecipientUser'])."', '" . $this->_escapeString($VAR['emailRecipientPass']) . "', '" . $this->_escapeString($VAR['emailRecipientName']) . "', ".$VAR['recipient_id'].")";
            // @formatter:on
            $this->_sqlObj->makeConn("main");
            $this->_sqlObj->makeQuery($insert);
        } else {
            // @formatter:off
            $update = "update t_login ".
                      "set login_name = '".$this->_escapeString($VAR['emailRecipientUser'])."', ".
                      "login_pass = '" . $this->_escapeString($VAR['emailRecipientPass']) . "', ".
                      "full_name = '" . $this->_escapeString($VAR['emailRecipientName']) . "', ".
                      "fk_recipient_id = ".$VAR['recipient_id']." ".
                      "where login_id = '" . $result . "'";
            // @formatter:on
            $this->_sqlObj->makeConn("main");
            $this->_sqlObj->makeQuery($update);
        }
    }

    public function addAdminData($VAR) {
        $result = $this->_checkLoginName($VAR['emailRecipientUser']);
        if($result == 0) {
            // @formatter:off
            $insert = "insert into t_login (login_name, login_pass, full_name, fk_recipient_id, is_admin) " .
                    "VALUES('".$this->_escapeString($VAR['emailRecipientUser'])."', '" . $this->_escapeString($VAR['emailRecipientPass']) . "', '" . $this->_escapeString($VAR['emailRecipientName']) . "', null, 1)";
            // @formatter:on
            $this->_sqlObj->makeConn("main");
            $this->_sqlObj->makeQuery($insert);
        }
    }

    private function _insertEntry($VAR) {
        $dateTokens = explode("-", $VAR['scheduleDateISO']);
        // @formatter:off
        $insert = "insert into t_schedule (month, day, year, message, single_message) " .
                  "VALUES('" . $this->_escapeString($dateTokens[1]) . "', " .
                  "'" . $this->_escapeString($dateTokens[2]) . "', " .
                  "'" . $this->_escapeString($dateTokens[0]) . "', " .
                  "'" . $this->_escapeString($VAR['scheduleMessage']) . "', ".
                  "'" . (isset($VAR['scheduleIsPeriodic']) ? "0" : "1") . "')";
        // @formatter:on
        $this->_sqlObj->makeConn("main");
        $this->_sqlObj->makeQuery($insert);
        $insertId = $this->_sqlObj->insertId();
        $this->_relateMessageToRecipient($insertId, $VAR['selectedRecipientId']);
    }

    private function _updateEntry($VAR) {
        if ($VAR['deleteEntry'] == "true") {
            $this->_deleteRelation($VAR['selectedScheduleEntry']);
            // @formatter:off
            $query = "delete from t_schedule ".
                     "where schedule_id = '" . $this->_escapeString($VAR['selectedScheduleEntry']) . "'";
            // @formatter:on
        } else {
            $dateTokens = explode("-", $VAR['scheduleDateISO']);
            // @formatter:off
            $query = "update t_schedule " .
                     "set day = '" . $this->_escapeString($dateTokens[2]) . "', " .
                     "month = '" . $this->_escapeString($dateTokens[1]) . "', " .
                     "year = '" . $this->_escapeString($dateTokens[0]) . "', " .
                     "single_message = '" . (isset($VAR['scheduleIsPeriodic']) ? "0" : "1") . "', " .
                     "message = '" . $this->_escapeString($VAR['scheduleMessage']) . "' " .
                     "where schedule_id = '" . $this->_escapeString($VAR['selectedScheduleEntry']) . "'";
            // @formatter:on
        }
        $this->_sqlObj->makeConn("main");
        $this->_sqlObj->makeQuery($query);
    }

    private function _checkAddress($address) {
        // @formatter:off
        $select = "select recipient_id from t_recipient " .
                  "where recipient_address = '" . $this->_escapeString($address) . "'";
        // @formatter:on
        $this->_sqlObj->makeConn("main");
        $result = $this->_sqlObj->makeQuery($select);
        return intval($result[0]['recipient_id']);
    }

    private function _checkLoginName($userName) {
        // @formatter:off
        $select = "select login_id from t_login " .
                "where login_name = '" . $this->_escapeString($userName) . "'";
        // @formatter:on
        $this->_sqlObj->makeConn("main");
        $result = $this->_sqlObj->makeQuery($select);
        return intval($result[0]['login_id']);
    }

    private function _relateMessageToRecipient($insertId, $recipientId) {
        // @formatter:off
        $insert = "insert into r_schedule_recipient " . "(fk_schedule_id, fk_recipient_id) " .
                  "VALUES('" . $insertId . "', '" . $recipientId . "')";
        // @formatter:on
        $this->_sqlObj->makeConn("main");
        $this->_sqlObj->makeQuery($insert);
    }

    public function _deleteEntry($selectedEntry) {
        // @formatter:off
        $sql = "delete from t_schedule " .
               "where schedule_id = '" . $selectedEntry . "'";
        // @formatter:on
        $this->_sqlObj->makeConn("main");
        $this->_sqlObj->makeQuery($sql);
    }

    private function _escapeString($string) {
        global $oSQL;
        $this->_sqlObj = $oSQL;
        return $this->_sqlObj->escapeString($string);
    }

    private function _updateLoginpassword($LOGINID, $newPassword) {
        // @formatter:off
        $sql = "update t_login " .
               "set login_pass = '" . $this->_escapeString($newPassword) . "' ".
               "where login_id= '" . $LOGINID . "'";
        // @formatter:on
        $this->_sqlObj->makeConn("main");
        $this->_sqlObj->makeQuery($sql);
    }

    private function _deleteRelation($selectedScheduleEntry) {
        // @formatter:off
        $sql = "delete from r_schedule_recipient " .
                "where fk_schedule_id = '" . $selectedScheduleEntry . "'";
        // @formatter:on
        $this->_sqlObj->makeConn("main");
        $this->_sqlObj->makeQuery($sql);
    }

}