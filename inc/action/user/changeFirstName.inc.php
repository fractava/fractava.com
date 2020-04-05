<?php

namespace action\user;

use session\sessionManager;

class changeFirstName extends \network\action{
    public function init(){
        $this->sessionManager = new sessionManager();
        $errors = array();
        
        if(!isset($this->params["newValue"])) {
            $errors[] = 0;
        }
        
        if(!$this->sessionManager->isLoggedIn()) {
            $errors[] = 7;
        }
        
        return $errors;
    }
    public function run(){
        $this->sessionManager->getLoggedInUser()->setAttribute("firstName", $this->params["newValue"]);
        echo "test";
        return array();
    }
}
?>
