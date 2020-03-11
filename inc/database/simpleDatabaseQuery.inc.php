<?php
namespace database;

use database\databaseController;

class simpleDatabaseQuery {
    public $statement;

    function __construct($sql,$parameters) {
        $databaseController = new databaseController();
        $this->statement = $databaseController->prepare($sql);
        $this->statement->execute($parameters);
    }
    function fetchAll() {
        return $this->statement->fetchAll();
    }
    function fetch() {
        return $this->statement->fetch();
    }
}