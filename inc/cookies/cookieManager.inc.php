<?php
namespace cookies;

use config\configManager;

class cookieManager {
    function cookiePermissionGranted() {
        return $_COOKIE["cookieLevel"] == "1";
    }
    function setCookie($name, $value, $expires = 0) {
        if($this->cookiePermissionGranted()){
            $config = configManager::getConfig();
            setcookie($name, $value, $expires, "/", $config["domain"]);
        }
    }
    function removeCookie($name) {
        setcookie($name, "", time()-(3600*24*365));
    }
}