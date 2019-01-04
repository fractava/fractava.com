<?php 
require_once($_SERVER['DOCUMENT_ROOT'] . "/account/inc/blockedIPs.inc.php");
session_start();
session_destroy();
unset($_SESSION['userid']);

//Remove Cookies
setcookie("identifier","",time()-(3600*24*365)); 
setcookie("securitytoken","",time()-(3600*24*365)); 

$redirect = $_GET["redirect"];
if($redirect != ""){
	header("location: " . $redirect);
}else{
	header("location: http://fractava.com/index.php");
}
?>
