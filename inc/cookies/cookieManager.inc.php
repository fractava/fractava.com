<?php
namespace cookies;

class cookieManager {
    function cookiePermissionGranted() {
        return $_COOKIE["cookieLevel"] == "1";
    }
    function setCookie($name, $value, $expires = 0) {
        if($this->cookiePermissionGranted()){
            setcookie($name, $value, $expires);
        }
    }
    function removeCookie($name) {
        setcookie($name, "", time()-(3600*24*365));
    }
}