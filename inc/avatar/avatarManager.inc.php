<?php

namespace avatar;

use database\selectQuery;
use user\userManagement;

class avatarManager {
    function getAvatarOfUser($id) {
        $userManagement = new userManagement();
        
        $avatar = json_decode($userManagement->findById($id)->getAttribute("avatar"), true);
        
        if($avatar["type"] == "pixelArt") {
            $pixelArt = new pixelArt();
            return $pixelArt->getImage($avatar["data"]);
        }else if($avatar["type"] == "file") {
            $image = new image();
            return $image->getImage($id, $avatar["filetype"]);
        }
    }
}