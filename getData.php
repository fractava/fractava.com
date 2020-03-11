<?php
require($_SERVER['DOCUMENT_ROOT'] . "/inc/autoload.inc.php");

$getDataName = $_POST["getData"];
if(isset($getDataName)){
    $className = "getData\\" . $getDataName;
    $action = new $className;
    
    $errors = $getData->init();
    //var_dump($errors);
    if(empty($errors)) {
        $getData->run();
    }
}