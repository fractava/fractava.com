<?php 
session_start();
require_once("inc/config.inc.php");
require_once("inc/functions.inc.php");
//include("templates/header.inc.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/account/inc/blockedIPs.inc.php");
?>

<?php
	$dev = false;
	$error = false;
	
	$vorname = trim($_POST['vorname']);
	$nachname = trim($_POST['nachname']);
	$Benutzername = trim($_POST['Benutzername']);
	$email = trim($_POST['email']);
	$passwort = $_POST['passwort'];
	$passwort2 = $_POST['passwort2'];
	
	if($_POST['masterpassword'] != "ReWjH8749357670#417XY744u33134"){
		//echo "Masterpassword falsch";
		$error = true;
	}
	if(empty($vorname) || empty($nachname) || empty($email) || empty($Benutzername)) {
		if($dev){
		echo '<b><p style ="color:white;">Bitte alle Felder ausfüllen</p></b><br>';
		}
		$error = true;
	}
  
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		if($dev){
		echo '<b><p style ="color:white;">Bitte eine gültige E-Mail-Adresse eingeben</p></b><br>';#
		}
		$error = true;
	} 	
	if(strlen($passwort) == 0) {
		if($dev){
		echo '<b><p style ="color:white;">Bitte ein Passwort angeben</p></b><br>';
		}
		$error = true;
	}
	if($passwort != $passwort2) {
		if($dev){
		echo '<b><p style= "color: white;">Die Passwörter müssen übereinstimmen</p></b><br>';
		}
		$error = true;
	}

	
	if (stristr($Benutzername, ' ')){
		if($dev){
		echo('<b><p style= "color: white;">Nutzernamen dürfen keine Leerzeichen enthalten</p></b><br>');
		}
		$error = true;
	}
	if(!preg_match("/[a-zA-Z_.]{3,16}$/",$Benutzername)) { 
		if($dev){
		echo '<b><p style= "color: white;">Du verwendest unerlaubte Sonderzeichen im Benutzernamen</p></b><br>';
		}
     		$error=true;
      } 

	
	//Überprüfe, dass die E-Mail-Adresse noch nicht registriert wurde
	if(!$error) { 
		$statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
		$result = $statement->execute(array('email' => $email));
		$user = $statement->fetch();
		
		if($user !== false) {
			if($dev){
			echo '<b><p style= "color: white;">Diese E-Mail-Adresse ist bereits vergeben</p></b><br>';
			}
			$error = true;
		}	
	}

	if(!$error) { 
		$statement = $pdo->prepare("SELECT * FROM users WHERE Benutzername = :Benutzername");
		$result = $statement->execute(array('Benutzername' => $Benutzername));
		$user = $statement->fetch();
		
		if($user !== false) {
			if($dev){
			echo '<b><p style= "color: white;">Dieser Benutzername ist bereits vergeben</p></b><br>';
			}
			$error = true;
		}	
	}

	//Keine Fehler, wir können den Nutzer registrieren
	if(!$error) {	
		
		$passwort_hash = password_hash($passwort, PASSWORD_DEFAULT);
		
		$statement = $pdo->prepare("INSERT INTO users (email, passwort, vorname, nachname, Benutzername) VALUES (:email, :passwort, :vorname, :nachname, :Benutzername)");
		$result = $statement->execute(array('email' => $email, 'passwort' => $passwort_hash, 'vorname' => $vorname, 'nachname' => $nachname, 'Benutzername' => $Benutzername));
		
		if($result) {		
			$error = false;
		} else {
			$error = true;
		}
	}else{
		$error = true;
		}
if($error){
	echo "[false]";
}else {
	echo "[true]";
}
