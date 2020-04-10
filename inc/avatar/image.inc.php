<?php

namespace avatar;

class image extends avatar{
    function getImage($userid, $filetype) {
        $path = $_SERVER['DOCUMENT_ROOT'] . "/assets/img/avatar/$userid.$filetype";
        if(file_exists($path)) {
            if($filetype == "png") {
                return $this->imageToString(imagecreatefrompng($path));
            }else if($filetype == "jpg" || $filetype == "jpeg") {
                return $this->imageToString(imagecreatefromjpeg($path));
            }
        }else {
            return false;
        }
    }
}