<?php
namespace user;

use database\simpleDatabaseQuery;
use user\user;

class userManagement {
    function findById($id) {
        $existsQuery = new simpleDatabaseQuery("SELECT COUNT(id) FROM users WHERE id=:id;", array("id" => $id));
        $count = $existsQuery->fetch()[0];
        if($count == "1"){
            return new user($id);
        }else {
            return false;
        }
    }
    function findByUsername($username) {
        $existsQuery = new simpleDatabaseQuery("SELECT COUNT(id) FROM users WHERE username=:username;", array("username" => $username));
        $count = $existsQuery->fetch()[0];
        if($count == "1"){
            $getIdQuery = new simpleDatabaseQuery("SELECT id FROM users WHERE username=:username;", array("username" => $username));
            $id = $getIdQuery->fetch()[0];
            return new user($id);
        }else {
            return false;
        }
    }
    function findByEmail($email) {
        $existsQuery = new simpleDatabaseQuery("SELECT COUNT(id) FROM users WHERE email=:email;", array("email" => $email));
        $count = $existsQuery->fetch()[0];
        if($count == "1"){
            $getIdQuery = new simpleDatabaseQuery("SELECT id FROM users WHERE email=:email;", array("email" => $email));
            $id = $getIdQuery->fetch()[0];
            return new user($id);
        }else {
            return false;
        }
    }
}