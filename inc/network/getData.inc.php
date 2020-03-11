<?php
namespace network;

abstract class getData extends \network\networkRequest{
    public $return_type = "json";
    public $params;
    
    function __construct() {
        $this->params = $_GET;
    }
}
       
/*Usage (action and get_data):
    *   Override functions:
    *       -init
    *       -run
    *   Don't ovveride function:
    *       -__construct
    *   Override values in init:
    *       -$errors
    *       -$returnType
    *   Call on execute:
    *       -init
    *       -run
*/