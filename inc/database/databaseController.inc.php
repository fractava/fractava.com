<?php
namespace database;

use config\configManager;

class databaseController {
    function __construct() {
        $config = configManager::getConfig();
        this.connect($config["db_host"], $config["db_name"], $config["db_user"], $config["db_password"]);
    }
    
    function connect($host, $name, $user, $password) {
        $pdo = new PDO("mysql:host=$host;dbname=$name", $user, $password);
        $initialized = true;
    }
}