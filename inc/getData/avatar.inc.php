<?php

namespace getData;

use avatar\avatarManager;
use user\userManagement;

class avatar extends \network\getData{
    
    public function init(){
        $this->returnType = "none";
        $errors = array();
        
        if(isset($this->params["userid"])) {
            $this->userid = $this->params["userid"];
        }elseif(isset($this->params["username"])) {
            $userManagement = new userManagement();
            $user = $userManagement->findByUsername($this->params["username"]);
            $this->userid = $user->getAttribute("id");
        }else {
            $errors[] = 0;
        }
        
        return $errors;
    }
    public function run(){
        $avatar = new avatarManager();
        
        $image = $avatar->getAvatarOfUser($this->userid);
        header ('Content-Type: image/png');
        imagepng($image);
    }
}
?>
