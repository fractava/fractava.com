<?php

namespace action;

use session\sessionManager;
use cookies\cookieManager;

class logout extends \network\action {
    function init(){
        return array();
    }
    function run() {
        $sessionManager = new sessionManager();
        $sessionManager->sessionStart();
        $sessionManager->sessionClose();
        
        unset($_SESSION['userid']);
        
        $cookieManager = new cookieManager();
        $cookieManager->removeCookie("identifier");
        $cookieManager->removeCookie("securitytoken");
    }
}