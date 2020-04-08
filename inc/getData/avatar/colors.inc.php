<?php

namespace getData\avatar;

use database\selectQuery;

class colors extends \network\getData{
    
    public function init(){
        $errors = array();
        return $errors;
    }
    public function run(){
        $result = array();
        $query = new selectQuery();
        $query
        ->from("pixelArtColors")
        ->getAll();
        $colors = $query->run();
        
        foreach($colors as $color) {
            $result[$color["name"]] = $color["value"];
        }
        return $result;
    }
}
?>
