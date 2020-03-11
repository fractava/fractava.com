<?php
namespace user;

use database\simpleDatabaseQuery;
use user\user;

class userManagement {
    function findById($id) {
        $query = new simpleDatabaseQuery("SELECT COUNT(id) FROM users WHERE id=:id;", array("id" => $id));
        $count = $query->fetch()[0];
        if($count == "1"){
            return new user($id);
        }else {
            return false;
        }
    }
    function findByUsername($username) {
        
    }
}