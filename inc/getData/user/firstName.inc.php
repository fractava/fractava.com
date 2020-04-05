<?php

namespace getData\user;

use session\sessionManager;

class firstName extends \network\getData{
    
    public $userInfo;
    
    public function init(){
        $this->sessionManager = new sessionManager();
        $errors = array();
        
        if(!$this->sessionManager->isLoggedIn()) {
            $errors[] = 7;
        }
        
        return $errors;
    }
    public function run(){
        $firstName = $this->sessionManager->getLoggedInUser()->getAttribute("firstName");
        return array("firstName" => $firstName);
    }
}
?>
