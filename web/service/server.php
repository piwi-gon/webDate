<?php
/**
 *
 * server.php
 *
 * author : piwi
 *
 * created: 28.12.2014
 * changed: 28.12.2014
 *
 * purpose:
 *
 */

ini_set("display_errors", 1);
$actDir = dirname(__FILE__);
@define("DS", DIRECTORY_SEPARATOR);
// include the basic-start
include_once($actDir . DS . "clistart.inc.php");

// and now for the wsdl -> nusoap
include_once($actDir . DS . "classes" . DIRECTORY_SEPARATOR . "nusoap" . DIRECTORY_SEPARATOR . "nusoap.php");

// and for the methods to display and for handling the requests the soap-main-class
include_once($actDir . DS . "functions.inc.php");

// some init-settings override
ini_set('soap.wsdl_cache_enabled', '0');
ini_set('soap.wsdl_cache_ttl', '0');

if(isset($_GET['wsdl']) || isset($_GET['WSDL'])) {
    $nusoap = new soap_server;

    $namespace = 'urn:testapi';
    $nusoap->configureWSDL('testapi', $namespace);
    $nusoap->wsdl->addComplexType('ArrayOfstring', 'complexType', 'array', '', 'SOAP-ENC:Array', array(), array(array('ref'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'string[]')), 'xsd:string' );

    foreach(get_class_methods("cPTFWManager") as $method){
        if(substr($method,0,1) != "_") {
            $reflect = new ReflectionMethod('cPTFWManager', $method);
            if($reflect->isPublic() && !$reflect->isStatic()){
                $input = array();
                foreach($reflect->getParameters() as $parameter) {
                    $input[$parameter->name] = 'xsd:string';
                }
                if($method == "queryDB") {
                    $nusoap->register($method, $input, array('return' => 'xsi:ArrayOfstring'), $namespace, false, 'rpc', 'encoded');
                } else {
                    $nusoap->register($method, $input, array('return' => 'xsd:string'), $namespace, false, 'rpc', 'encoded');
                }
            }
        }
    }

    $nusoap->service(isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : '');
} else {
    $server = new SoapServer(null, array('uri' => 'urn:testapi'));
    $server->setClass("cPTFWManager");
    $server->handle();
}
?>