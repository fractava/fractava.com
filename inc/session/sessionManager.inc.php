<?php
namespace session;

use user\user;

class sessionManager {
    function sessionStart() {
        if($_COOKIE["cookieLevel"] == "1"){
            session_start();
            return true;
        }else {
            return false;
        }
    }
    function sessionClose() {
        session_destroy();
        setcookie("PHPSESSID","",time()-(3600*24*365));
    }
    function isLoggedIn() {
        $this->sessionStart();
        if(isset($_SESSION['userid'])){
            return true;
        }else {
            $this->sessionClose();
            return false;
        }
    }
    function getLoggedInUser() {
        $this->sessionStart();
        if($this->isLoggedIn()){
            return new user($_SESSION['userid']);
        }else {
            return false;
        }
    }
}