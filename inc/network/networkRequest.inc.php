<?php
namespace network;

abstract class networkRequest{

    public function init(){}
    
    public function run(){}
    
    public function getThis(){
        return $this;
    }
}
?>
