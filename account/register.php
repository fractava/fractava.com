<?php 
$recaptcha = $_POST["g-recaptcha-response"];
session_start();
require_once("inc/config.inc.php");
require_once("inc/functions.inc.php");
include($_SERVER['DOCUMENT_ROOT'] . "/account/inc/recaptcha.inc.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/account/templates/main_link.php");
include("templates/header.inc.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/account/inc/blockedIPs.inc.php");
?>
<head>
	<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-112803937-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-112803937-1');
</script>
<script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<script type="text/javascript">
var onloadCallback = function() {
grecaptcha.render('html_element', {
'sitekey' : '6LeJZ0QUAAAAACG4Cyf7SWBbO-mOwhIme-tZrLeD'
});
};
</script>
<div class="container main-container registration-form">
<h1 style="color: white;text-align:center;font-family: 'nextfont';">Registrierung</h1>
<body style="background-color: black;"> </body>
<?php
$showFormular = true;
 
if(isset($_GET['register'])) {
	$error = false;
	$vorname = trim($_POST['vorname']);
	$nachname = trim($_POST['nachname']);
	$Benutzername = trim($_POST['Benutzername']);
	$email = trim($_POST['email']);
	$passwort = $_POST['passwort'];
	$passwort2 = $_POST['passwort2'];
	$recaptchaTrue = recaptcha_correct("***REMOVED***" , $recaptcha);
	//var_dump($_POST['angemeldet_bleiben']);
	if(!isset($_POST['angemeldet_bleiben'])) {
		echo '<b><p style ="color:white;">Du musst über 16 sein um dich registrieren zu können</p></b><br>';
		$error = true;
	}
	if(!$recaptchaTrue){
		echo '<b><p style ="color:white;">Bitte Captcha bestätigen</p></b><br>';
		$error = true;
	}
	if(empty($vorname) || empty($nachname) || empty($email) || empty($Benutzername)) {
		echo '<b><p style ="color:white;">Bitte alle Felder ausfüllen</p></b><br>';
		$error = true;
	}
  
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		echo '<b><p style ="color:white;">Bitte eine gültige E-Mail-Adresse eingeben</p></b><br>';
		$error = true;
	} 	
	if(strlen($passwort) == 0) {
		echo '<b><p style ="color:white;">Bitte ein Passwort angeben</p></b><br>';
		$error = true;
	}
	if($passwort != $passwort2) {
		echo '<b><p style= "color: white;">Die Passwörter müssen übereinstimmen</p></b><br>';
		$error = true;
	}

	
	if (stristr($Benutzername, ' ')){
   		echo('<b><p style= "color: white;">Nutzernamen dürfen keine Leerzeichen enthalten</p></b><br>');
		$error = true;
	}
	if(!preg_match("/[a-zA-Z_.]{3,16}$/",$Benutzername)) { 
     		echo '<b><p style= "color: white;">Du verwendest unerlaubte Sonderzeichen im Benutzernamen</p></b><br>'; 
     		$error=true;
      } 

	
	//Überprüfe, dass die E-Mail-Adresse noch nicht registriert wurde
	if(!$error) { 
		$statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
		$result = $statement->execute(array('email' => $email));
		$user = $statement->fetch();
		
		if($user !== false) {
			echo '<b><p style= "color: white;">Diese E-Mail-Adresse ist bereits vergeben</p></b><br>';
			$error = true;
		}	
	}

	if(!$error) { 
		$statement = $pdo->prepare("SELECT * FROM users WHERE Benutzername = :Benutzername");
		$result = $statement->execute(array('Benutzername' => $Benutzername));
		$user = $statement->fetch();
		
		if($user !== false) {
			echo '<b><p style= "color: white;">Dieser Benutzername ist bereits vergeben</p></b><br>';
			$error = true;
		}	
	}

	//Keine Fehler, wir können den Nutzer registrieren
	if(!$error) {	
		
		$passwort_hash = password_hash($passwort, PASSWORD_DEFAULT);
		
		$statement = $pdo->prepare("INSERT INTO users (email, passwort, vorname, nachname, Benutzername) VALUES (:email, :passwort, :vorname, :nachname, :Benutzername)");
		$result = $statement->execute(array('email' => $email, 'passwort' => $passwort_hash, 'vorname' => $vorname, 'nachname' => $nachname, 'Benutzername' => $Benutzername));
		
		if($result) {		
			echo '<b><p style="color: white">Du wurdest erfolgreich registriert. <a style ="color:white;text-align: center;" href="login.php">Zum Login</a></p></b>';
			$showFormular = false;
		} else {
			echo '<b><p style="color: white">Beim Abspeichern ist leider ein Fehler aufgetreten</p></b><br>';
		}
	} 
}

if($showFormular) {
?>

<form action="?register=1" method="post" style="font-family: 'timeburner';">
<style>
		.inputBox {outline: 0 none;color:gray ;background-color: black;border-top: none;border-bottom: 2px solid gray;border-left: none;border-right: none;width: 100%;height:34px;box-sizing: border-box;padding: 6px 4px;}
		.inputBox:focus {outline: 0 none;border-bottom: 2px solid white;color:white;}
</style>
<div class="form-group">
<label style="color: white;" for="inputVorname">Vorname:</label>
<input type="text" class="inputBox" id="inputVorname" size="40" maxlength="250" name="vorname" required autofocus>
</div>

<div class="form-group">
<label style="color: white;" for="inputNachname">Nachname:</label>
<input type="text" class="inputBox" id="inputNachname" size="40" maxlength="250" name="nachname" required>
</div>

<div class="form-group">
<label style="color: white;" for="inputBenutzername">Benutzername (nachträglich nicht änderbar):</label>
<input type="text" class="inputBox" id="inputBenutzername" size="40" maxlength="16" name="Benutzername"  required>
</div>

<div class="form-group">
<label style="color: white;" for="inputEmail">E-Mail:</label>
<input type="email" class="inputBox" id="inputEmail" size="40" maxlength="250" name="email" required>
</div>

<div class="form-group">
<label style="color: white;" for="inputPasswort">Dein Passwort:</label>
<input type="password" class="inputBox" id="inputPasswort" size="40"  maxlength="250" name="passwort" required>
</div> 

<div class="form-group">
<label style="color: white;" for="inputPasswort2">Passwort wiederholen:</label>
<input type="password" class="inputBox" id="inputPasswort2" size="40" maxlength="250" name="passwort2" required>
</div> 
<div class="form-group">
<div class="checkbox">
	  <label style="color: white;">
		<input  type="checkbox" value="remember-me" name="angemeldet_bleiben" value="0"> Ich bin über 16
	  </label>
	</div>
</div>
<div id="html_element"></div>
<br>
<input style="background: white;color: black;border-radius: 0px;width: 100%;text-decoration: none;padding: 10px 16px;font-size: 18px;border : none;" type="submit" value="Registrieren" />
</form>
<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
 
<?php
} //Ende von if($showFormular)
	

?>
</div>
<?php 
//include("templates/footer.inc.php")
?>
