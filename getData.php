<?php
require($_SERVER['DOCUMENT_ROOT'] . "/inc/autoload.inc.php");

use xml\xml;

$getDataName = $_GET["getData"];
if(isset($getDataName)){
    $className = "getData\\" . $getDataName;
    
    if(class_exists($className)) {
        $getData = new $className;
    
        $errors = $getData->init();
        if(empty($errors)) {
            $results = $getData->run();
        }else {
            http_response_code(400);
        }
        
        $xml = new \SimpleXMLElement('<?xml version="1.0"?><request></request>');
        $xml_errors = $xml->addChild("errors");
        $xml_results = $xml->addChild("results");
        
        if(is_array($errors)) {
            foreach($errors as $error) {
                $xml_error = $xml_errors->addChild("error");
                $xml_error->addAttribute("id", $error);
            }
        }
        
        if(is_array($results)) {
            foreach($results as $key => $value) {
                $xml_results->addChild($key, $value);
            }
        }
        
        header('Content-Type: application/xml; charset=utf-8');
        echo $xml->asXML();
    }else {
        http_response_code(404);
    }
}