<?php
/*
 * tAuth.inc.php
 *
 * author: klaus
 *
 * created: 29.04.2018
 * changed: 29.04.2018
 *
 */


trait tAuth {

    private $auth=false;
    private $_salt;

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
        if($result[0]['login_pass'] == $this->_encodePassword($VAR['currentPassword'], $result[0]['salt'])) {
            $this->_updateLoginpassword($LOGINID, $VAR['newPassword']);
            return "success";
        } else {
            return "Falsches Passwort";
        }
    }

    public function addLoginData($VAR) {
        $result = $this->_checkLoginName($VAR['emailRecipientUser']);
        if($VAR['autoPassword'] == "true") { $VAR['emailRecipientPass'] = $this->_createAutoPassword(); }
        else { $VAR['emailRecipientPass'] = $this->_encodePassword($VAR['emailRecipientPass']);}
        if($result == 0) {
            // @formatter:off
            $insert = "insert into t_login (login_name, login_pass, full_name, fk_recipient_id, salt) " .
                      "VALUES('".$this->_escapeString($VAR['emailRecipientUser'])."', ".
                      "'" . $this->_escapeString($VAR['emailRecipientPass']) . "', ".
                      "'" . $this->_escapeString($VAR['emailRecipientName']) . "', ".
                      $VAR['recipient_id'].", ".
                      "'" . $this->_salt . "')";
            // @formatter:on
            $this->_sqlObj->makeConn("main");
            $this->_sqlObj->makeQuery($insert);
            $this->_sendLoginDataToRecipientAddress($VAR);
        } else {
            // @formatter:off
            $update = "update t_login ".
                      "set login_name = '".$this->_escapeString($VAR['emailRecipientUser'])."', ".
                      "login_pass = '" . $this->_escapeString($VAR['emailRecipientPass']) . "', ".
                      "full_name = '" . $this->_escapeString($VAR['emailRecipientName']) . "', ".
                      "salt = '" . $this->_salt . "', ".
                      "fk_recipient_id = ".$VAR['recipient_id']." ".
                      "where login_id = '" . $result . "'";
            // @formatter:on
            $this->_sqlObj->makeConn("main");
            $this->_sqlObj->makeQuery($update);
        }
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

    private function _updateLoginpassword($LOGINID, $newPassword) {
        // @formatter:off
        $sql  = "update t_login " .
                "set login_pass = '" . $this->_escapeString($this->_encodePassword($newPassword)) . "', ".
                "salt = '" . $this->_salt . "' ".
                "where login_id= '" . $LOGINID . "'";
        // @formatter:on
        $this->_sqlObj->makeConn("main");
        $this->_sqlObj->makeQuery($sql);
    }

    private function _createAutoPassword() {
        $emailRecipientPass = $this->_createPassword(10);
        return $this->_encodePassword($emailRecipientPass);
    }

    private function _encodePassword($thePassWord, $salt = "") {
        if($salt=="") {
            $this->_salt = md5(unique_id().mt_rand().microtime());
        } else {
            $this->_salt = $salt;
        }
        $pass = sha1($this->_salt.$thePassWord);
        return $pass;
    }

    private function _createPassword($lengthOfPassword = 20) {
        $chars =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'.
                  '0123456789-=!@#$%&*()_+/?§';
        $str = '';
        $max = strlen($chars) - 1;
        for ($i=0; $i < $lengthOfPassword; $i++) { $str .= $chars[random_int(0, $max)]; }
        return $str;
    }

    private function _sendLoginDataToRecipientAddress($VAR) {
        $additionalHeader = "From: ".$this->getOptionValue("sender_name")." <".$this->getOptionValue("sender_address").">";
        $from = $this->getOptionValue("sender_address");
        $msg  = "Willkommen bei Webdate V2.0\n\n".
                "Sie haben folgenden Zugang erteilt bekommen:\n".
                "Benutzername: " . $VAR['emailRecipientName']."\n".
                "Passwort: " . $VAR['emailRecipientAddress']."\n\n".
                "Dies ist eine automatische EMail - Bitte nicht antworten!";
        mail($VAR['emailRecipientAddress'], $from, $msg, $additionalHeader);
    }

}