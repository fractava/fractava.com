<?php

namespace avatar;

use database\selectQuery;

class pixelArt extends avatar {
    function getImage($data) {
        $width = 16;
        $height = 16;
        
        $colors = $this->getPixelArtColors();
        
        $im = @imagecreatetruecolor($width, $height);
        
        $avatarLines = explode ("|" ,$data);
        
        for($y = 0; $y< $height; $y++){
        	$avatarLine = explode(";" ,$avatarLines[$y]);
        	
        	for($x = 0;$x < $width; $x++){
        		$color = imagecolorallocate($im,$colors[$avatarLine[$x]][0],$colors[$avatarLine[$x]][1],$colors[$avatarLine[$x]][2]);
        		imagesetpixel($im,$x,$y,$color);
        	}
        }
        
        return $im;
    }
    private function getPixelArtColors() {
        $query = new selectQuery();
        $query
        ->from("pixelArtColors")
        ->getAll();
        
        $colorsHEX = $query->run();
        
        $colorsRGB = array();
        
        foreach($colorsHEX as $color) {
            $colorsRGB[] = $this->hexToRgb($color["value"]);
        }
        
        return $colorsRGB;
    }
    private function hexToRgb($hex) {
       $hex = str_replace("#", "", $hex);
    
       if(strlen($hex) == 3) {
          $r = hexdec(substr($hex,0,1).substr($hex,0,1));
          $g = hexdec(substr($hex,1,1).substr($hex,1,1));
          $b = hexdec(substr($hex,2,1).substr($hex,2,1));
       } else {
          $r = hexdec(substr($hex,0,2));
          $g = hexdec(substr($hex,2,2));
          $b = hexdec(substr($hex,4,2));
       }
       $rgb = array($r, $g, $b);
       return $rgb;
    }
}