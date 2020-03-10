<?php
namespace config;

class configManager {
    function getConfig() {
        require_once($_SERVER['DOCUMENT_ROOT'] . "/config/config.inc.php");
        return $CONFIG;
    }
}