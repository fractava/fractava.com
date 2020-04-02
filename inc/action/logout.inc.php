<?php

namespace action;

use user\userManagement;

class logout extends \network\action {
    function init(){
        return array();
    }
    function run() {
        $userManagement = new userManagement();
        $userManagement->logout();
    }
}