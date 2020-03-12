<?php
namespace session;

use user\user;
use cookies\cookieManager;

class sessionManager {
    function sessionStart() {
        $cookieManager = new cookieManager();
        if($cookieManager->cookiePermissionGranted()) {
            session_start();
            return true;
        }else {
            return false;
        }
    }
    function sessionClose() {
        session_destroy();
        $cookieManager = new cookieManager();
        $cookieManager->removeCookie("PHPSESSID");
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