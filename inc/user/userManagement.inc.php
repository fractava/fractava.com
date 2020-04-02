<?php
namespace user;

use database\simpleDatabaseQuery;
use database\selectQuery;
use user\user;
use password\encryption;
use cookies\cookieManager;
use session\sessionManager;

class userManagement {
    function checkLogin($email, $password) {
        $errors = array();
        
        if(!(isset($email) && isset($password))){
            $errors[] = 0;
        }
        
        if(empty($errors)) {
            $user = $this->findByEmail($email);
            
            //check email
            if ($user == false){
                $errors[] = 10;
            }
            
            //check password
            if(!encryption::checkPassword($password, $user->getAttribute("password"))){
                $errors[] = 10;
            }
        }
        return $errors;
    }
    function loginByEmail($email) {
        $userId = $this->findByEmail($email)->getAttribute("id");
        return $this->loginById($userId);
    }
    function loginById($id) {
        $sessionManager = new sessionManager();
        $sessionManager->sessionStart();

    	$_SESSION['userid'] = $id;
    
    	$identifier = encryption::randomString();
    	$securitytoken = encryption::randomString();
    	
    	$insert = new simpleDatabaseQuery("INSERT INTO securityTokens (user_id, identifier, securitytoken) VALUES (:user_id, :identifier, :securitytoken);", array('user_id' => $id, 'identifier' => $identifier, 'securitytoken' => sha1($securitytoken)));
        
        $cookieManager = new cookieManager();
        $cookieManager->setCookie("identifier",$identifier,time()+(3600*24*365));
        $cookieManager->setCookie("securitytoken",$securitytoken,time()+(3600*24*365));
        
        return array("identifier" => $identifier, "securitytoken" => $securitytoken);
    }
    function findById($id) {
        $existsQuery = new simpleDatabaseQuery("SELECT COUNT(id) FROM users WHERE id=:id;", array("id" => $id));
        $count = $existsQuery->fetch()[0];
        if($count == "1"){
            return new user($id);
        }else {
            return false;
        }
    }
    function findByUsername($username) {
        $existsQuery = new simpleDatabaseQuery("SELECT COUNT(id) FROM users WHERE username=:username;", array("username" => $username));
        $count = $existsQuery->fetch()[0];
        if($count == "1"){
            $getIdQuery = new simpleDatabaseQuery("SELECT id FROM users WHERE username=:username;", array("username" => $username));
            $id = $getIdQuery->fetch()[0];
            return new user($id);
        }else {
            return false;
        }
    }
    function findByEmail($email) {
        $existsQuery = new simpleDatabaseQuery("SELECT COUNT(id) FROM users WHERE email=:email;", array("email" => $email));
        $count = $existsQuery->fetch()[0];
        if($count == "1"){
            $getIdQuery = new simpleDatabaseQuery("SELECT id FROM users WHERE email=:email;", array("email" => $email));
            $id = $getIdQuery->fetch()[0];
            return new user($id);
        }else {
            return false;
        }
    }
}