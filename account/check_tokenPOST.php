<?php
require_once("inc/config.inc.php");
require_once("inc/functions.inc.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/account/inc/blockedIPs.inc.php");

$identifier = $_POST["identifier"];
$securitytoken = $_POST["securitytoken"];
if($_POST["masterpassword"] == "ReWjH8749357670#417XY744u33134"){
	check_token($identifier,$securitytoken);
}
?>
