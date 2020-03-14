<?php
namespace action;

use password\encryption;
use database\simpleDatabaseQuery;

class register extends \network\action {
    public function init() {
        $this->firstName = trim($_POST['firstName']);
        $this->lastName = trim($_POST['lastName']);
        $this->username = trim($_POST['username']);
        $this->email = trim($_POST['email']);
        $this->password = $_POST['password'];

        if(empty($this->firstName) || empty($this->lastName) || empty($this->email) || empty($this->username)) {
        	$errors[] = 0;
        }
        
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
        	$errors[] = 1;
        } 	
        if(strlen($this->password) < 5) {
        	$errors[] = 2;
        }
        	
        if (stristr($this->username, ' ')){
        	$errors[] = 3;
        }
        if(!preg_match("/[a-zA-Z0-9_.]{3,16}$/", $this->username)) {
            $errors[] = 4;
        } 
        
        
        if(empty($errors)) {
        	$emailAvailableQuery = new simpleDatabaseQuery("SELECT * FROM users WHERE email = :email", array('email' => $this->email));
        	$emailRegistered = $emailAvailableQuery->fetch();
        	
        	if($emailRegistered !== false) {
        		$errors[] = 5;
        	}	
        }
        
    	if(empty($errors)) {
    		$usernameAvailableQuery = new simpleDatabaseQuery("SELECT * FROM users WHERE username = :username", array('username' => $this->username));
    		$usernameRegistered = $usernameAvailableQuery->fetch();
    		
    		if($usernameRegistered !== false) {
    			$errors[] = 6;
    		}
    	}
    	
    	return $errors;
    }
    public function run() {
        $passwordHash = encryption::hashPassword($this->password);
        
        $sql = "INSERT INTO users (email, password, firstName, lastName, username) VALUES (:email, :password, :firstName, :lastName, :username)";
        $sqlValues = array('email' => $this->email, 'password' => $passwordHash, 'firstName' => $this->firstName, 'lastName' => $this->lastName, 'username' => $this->username);
        $insertQuery = new simpleDatabaseQuery($sql, $sqlValues);
    }
}