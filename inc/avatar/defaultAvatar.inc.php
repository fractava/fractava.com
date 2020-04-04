<?php

namespace avatar;

class defaultAvatar extends avatar{
    function getImage() {
        return imagecreatefrompng($_SERVER['DOCUMENT_ROOT'] . "/assets/img/account.png");
    }
}