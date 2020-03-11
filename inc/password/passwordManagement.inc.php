<?php

namespace password;

use user\user;
use password\encryption;

class passwordManagement {
    function checkPassword($userId,$password) {
        $user = new user($userId);
        $hash = $user->getAttribute("password");

        return encryption::checkPassword($password, $hash);
    }
}