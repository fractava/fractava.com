<?php
namespace database;

use config\configManager;

class databaseController {
    function __construct() {
        $config = configManager::getConfig();
        $this->connect($config["db_host"], $config["db_name"], $config["db_user"], $config["db_password"]);
    }
    
    function connect($host, $name, $user, $password) {
        $this->$pdo = new \PDO("mysql:host=$host;dbname=$name", $user, $password);
        $initialized = true;
    }
    
    function prepare($sql) {
        return $this->$pdo->prepare($sql);
    }
    function getColumnsOfTable($table) {
        $database = configManager::getConfig()["db_name"];
        
        $columnNameStatement = $this->prepare("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = :database AND TABLE_NAME = :table");
        $columnNameStatement->execute(array("database" => $database, "table" => $table));
        $columnNames = $columnNameStatement->fetchAll();
        
        $columnNamesResorted = array();
        
        foreach($columnNames as $name){
            $columnNamesResorted[] = $name["COLUMN_NAME"];
        }
        
        return $columnNamesResorted;
    }
}