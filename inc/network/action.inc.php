<?php
namespace network;

abstract class action extends \network\networkRequest{
    public $return_type = "json";
    public $params;
    
    function __construct() {
        $this->params = $_POST;
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