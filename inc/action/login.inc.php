<?php

namespace action;

use password\encryption;
use database\simpleDatabaseQuery;
use cookies\cookieManager;
use session\sessionManager;

class login extends \network\action{
    
    public $userInfo;
    
    public function init(){
        $errors = array();
        
        // Check for params
        if(!(isset($this->params['email']) && isset($this->params['password']))){
            $errors[] = 0;
        }
        
        //check email
        $query = new simpleDatabaseQuery("SELECT * FROM users WHERE email = :email", array('email' => $this->params['email']));
        $this->userInfo = $query->fetch();
        if ($this->userInfo == false){
            $errors[] = 10;
        }
        
        //check password
        if(!encryption::checkPassword($this->params['password'], $this->userInfo['password'])){
            $errors[] = 10;
        }
        return $errors;
    }
    public function run(){
        $sessionManager = new sessionManager();
        $sessionManager->sessionStart();

    	$_SESSION['userid'] = $this->userInfo['id'];
    
    	$identifier = encryption::randomString();
    	$securitytoken = encryption::randomString();
    	
    	$insert = new simpleDatabaseQuery("INSERT INTO securityTokens (user_id, identifier, securitytoken) VALUES (:user_id, :identifier, :securitytoken);", array('user_id' => $this->userInfo['id'], 'identifier' => $identifier, 'securitytoken' => sha1($securitytoken)));
        
        $cookieManager = new cookieManager();
        $cookieManager->setCookie("identifier",$identifier,time()+(3600*24*365));
        $cookieManager->setCookie("securitytoken",$securitytoken,time()+(3600*24*365));
    }
}

return new login();
?>
