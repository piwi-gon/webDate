<?php
/*
 * tWebDateOptions.inc.php
 *
 * author: klaus
 *
 * created: 28.04.2018
 * changed: 28.04.2018
 *
 */


trait tWebdateOptions {

    public function getOptionValue($optionName) {
        $select = "select * from t_configuration_option where option_name = '" . $optionName . "'";
        $this->_sqlObj->makeConn("main");
        $result = $this->_sqlObj->makeQuery($select);
        return $result[0]['option_value'];
    }

    public function queryWebDateOptions() {
        $select = "select * from t_configuration_option";
        $this->_sqlObj->makeConn("main");
        $result = $this->_sqlObj->makeQuery($select);
        return $result;
    }

    public function saveWebDateOptions($VAR) {
        $options = $this->queryWebDateOptions();
        $this->_sqlObj->makeConn("main");
        foreach($options as $opt) {
            $update = "update t_configuration_option ".
                      "set option_value = '" . $this->_sqlObj->escapeString($VAR[$opt['option_name']])."' ".
                      "where option_name = '". $opt['option_name']."'";
            echo "SQL: " . $update . "\n";
            $this->_sqlObj->makeQuery($update);
        }
    }
}