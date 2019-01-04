<?php 
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . "/account/inc/config.inc.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/account/inc/functions.inc.php");

//Gesperrte IPs 

$statement = $pdo->prepare("SELECT IP FROM blockedIPs");
$statement->execute();
while($row = $statement->fetch()) {
	$ip[] = $row["IP"];
}

    foreach($ip as $testIP){
		if($_SERVER["REMOTE_ADDR"] == $testIP){
			echo "blocked";
			exit;
		}
	}

?>

