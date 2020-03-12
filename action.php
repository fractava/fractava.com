<?php
require($_SERVER['DOCUMENT_ROOT'] . "/inc/autoload.inc.php");

$actionName = $_POST["action"];
if(isset($actionName)){
    $className = "action\\" . $actionName;
    
    if(class_exists($className)) {
        $action = new $className;
    
        $errors = $action->init();
        var_dump($errors);
        if(empty($errors)) {
            $action->run();
        }
    }
}