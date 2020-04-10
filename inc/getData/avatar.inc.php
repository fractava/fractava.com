<?php

namespace getData;

use avatar\avatarManager;
use user\userManagement;

class avatar extends \network\getData{
    public $clearOutput = false;
    
    public function init(){
        $this->returnType = "xml";
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
        $type = $avatar->getAvatarTypeOfUser($this->userid);
        return array("imageData" => (string)$image, "avatarType" => $type);
    }
}
?>
