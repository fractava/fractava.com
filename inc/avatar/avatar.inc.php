<?php

namespace avatar;

abstract class avatar {
    function imageToString($image) {
        ob_start();
        imagepng($image);
        return base64_encode(ob_get_clean());
    }
}