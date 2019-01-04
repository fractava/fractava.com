<?php 
session_start();
require_once("inc/config.inc.php");
require_once("inc/functions.inc.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/account/inc/blockedIPs.inc.php");

$error_msg = "";
if(isset($_POST['email']) && isset($_POST['passwort']) /*isset($_POST['masterpassword'])*/) {
	$email = $_POST['email'];
	$passwort = $_POST['passwort'];

	$statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
	$result = $statement->execute(array('email' => $email));
	$user = $statement->fetch();

	if($user == false){
		$statement = $pdo->prepare("SELECT * FROM users WHERE Benutzername = :Benutzername");
		$result = $statement->execute(array('Benutzername' => $email));
		$user = $statement->fetch();
	}


	//Überprüfung des Passworts
	if ($user !== false && password_verify($passwort, $user['passwort']) && $_POST['masterpassword'] == 'ReWjH8749357670#417XY744u33134') {
		$_SESSION['userid'] = $user['id'];
		//echo $user['id'];
		echo "[true]";
		
		//Möchte der Nutzer angemeldet beleiben?
		if($_POST['getToken'] == "true") {
			$identifier = random_string();
			$securitytoken = random_string();
				
			$insert = $pdo->prepare("INSERT INTO securitytokens (user_id, identifier, securitytoken) VALUES (:user_id, :identifier, :securitytoken)");
			$insert->execute(array('user_id' => $user['id'], 'identifier' => $identifier, 'securitytoken' => sha1($securitytoken)));
			echo "|";
			echo "[" . $identifier . "]";
			echo "|";
			echo "[" . $securitytoken . "]";
			//setcookie("identifier",$identifier,time()+(3600*24*365)); //Valid for 1 year
			//setcookie("securitytoken",$securitytoken,time()+(3600*24*365)); //Valid for 1 year
		}

		
		exit;
	} else {
		echo "[false]";
	}

}

//$email_value = "";
//if(isset($_POST['email']))
//	$email_value = htmlentities($_POST['email']);  

?>

