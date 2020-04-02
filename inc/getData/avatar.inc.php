<?php

namespace getData;

use avatar\avatarManager;

class avatar extends \network\getData{
    
    public function init(){
        $this->returnType = "none";
        $errors = array();
        
        if(!isset($this->params["userid"])) {
            $errors[] = 0;
        }
        
        return $errors;
    }
    public function run(){
        $avatar = new avatarManager();
        
        $image = $avatar->getAvatarOfUser($this->params["userid"]);
        header ('Content-Type: image/png');
        imagepng($image);
    }
}
?>
