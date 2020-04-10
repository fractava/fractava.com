<?php

namespace avatar;

class defaultAvatar extends avatar{
    function getImage() {
        return $this->imageToString(imagecreatefrompng($_SERVER['DOCUMENT_ROOT'] . "/assets/img/account.png"));
    }
}