<?php

namespace action;

use user\userManagement;

class login extends \network\action{
    public function init(){
        $this->userManagement = new userManagement();
        return $this->userManagement->checkLogin($this->params['email'], $this->params['password']);
    }
    public function run(){
        return $this->userManagement->loginByEmail($this->params["email"]);
    }
}
?>
