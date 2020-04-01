<?php

namespace blog;

use database;

class entry {
    function __construct($initId) {
        $this->id = $initId;
    }
    function getAttribute($attribute) {
        $query = new selectQuery();
        $query->from("blogEntries")
        ->get(array($attribute))
        ->where("id", $this->id)
        ->limit(1);
        $result = $query->run()[0][$attribute];
        
        return $result;
    }
    function setAttribute($attribute, $value) {
        
    }
}

?>