<?php

namespace blog;

class blogManager {
    function __construct() {
        
    }
    function getAllEntries() {
        
    }
    function getEntries($offset, $count, $sort = "created") {
        
    }
    function getEntryById($id) {
        return new blog\entry($id);
    }
}