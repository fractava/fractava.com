<?php
namespace user;

use database\databaseController;
use database\simpleDatabaseQuery;

class user {
    function __construct($initId) {
        $this->$id = $initId;
    }
    function getAttribute($attribute) {
        if($this->validAttribute($attribute)){
            $query = new simpleDatabaseQuery("SELECT * FROM users WHERE id=:id LIMIT 1;",array("id" => $this->$id));
            $attributes = $query->fetch();
            return $attributes[$attribute];
        }else {
            return false;
        }
    }
    function setAttribute($attribute, $value) {
        if($this->validAttribute($attribute)){
            $query = new simpleDatabaseQuery("UPDATE users Set " . $attribute . " = :value WHERE id=:id LIMIT 1;",array("value" => $value, "id" => $this->$id));
        }else {
            return false;
        }
    }
    private function validAttribute($attribute) {
        if(preg_match("/^[\w.-]*$/", $attribute) == 0) {
            return false;
        }
        
        $databaseController = new databaseController();
        $columns = $databaseController->getColumnsOfTable("users");
        if(!in_array($attribute, $columns)){
            return false;
        }
        
        return true;
    }
}