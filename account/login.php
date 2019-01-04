<?php
$redirect = $_GET['redirect'];
$recaptcha = $_POST["g-recaptcha-response"];
//echo "<p style =\"color:white;\">" . urlRequest('https://www.google.com/recaptcha/api/siteverify', 'Mozilla/5.0 (X11; Ubuntu; Linux x86; rv:28.0) Gecko/20100101 Firefox/28.0', true, '', "secret=\"***REMOVED***\"&response=\"". $recaptcha. "\"") . "</p>";

include($_SERVER['DOCUMENT_ROOT'] . "/account/inc/recaptcha.inc.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/account/templates/main_link.php");
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

<title>FRACTAVA - Login</title>
<body style="background-color: black;">
<?php 
session_start();
require_once("inc/config.inc.php");
require_once("inc/functions.inc.php");

//var_dump(getSiteURL());
redirectToSSL();

$error_msg = "";

if(isset($_POST['email']) && isset($_POST['passwort'])) {
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

	$statement = $pdo->prepare("SELECT blocked FROM users WHERE blocked = 1");
	$result = $statement->execute();
	$blocked = $statement->fetch();
	
	//Überprüfung des Passworts
	$recaptchaTrue = recaptcha_correct("***REMOVED***" , $recaptcha);
	
	if ($user !== false && password_verify($passwort, $user['passwort']) && $recaptchaTrue && $blocked == false) {
		$_SESSION['userid'] = $user['id'];

		//Möchte der Nutzer angemeldet beleiben?
		if(isset($_POST['angemeldet_bleiben'])) {
			$identifier = random_string();
			$securitytoken = random_string();
				
			$insert = $pdo->prepare("INSERT INTO securitytokens (user_id, identifier, securitytoken) VALUES (:user_id, :identifier, :securitytoken)");
			$insert->execute(array('user_id' => $user['id'], 'identifier' => $identifier, 'securitytoken' => sha1($securitytoken)));
			setcookie("identifier",$identifier,time()+(3600*24*365)); //Valid for 1 year
			setcookie("securitytoken",$securitytoken,time()+(3600*24*365)); //Valid for 1 year
		}
		
		if(isset($_GET['redirect'])){
			header("location: " . $redirect);
		}else{
			header("location: http://fractava.com/index.php");
		}
		exit;
	} else {
		$error_msg =  "E-Mail oder Passwort war ungültig<br><br>";
		if(!$recaptchaTrue){
			$error_msg = "Captcha bitte bestätigen";
		}
	}

}

$email_value = "";
if(isset($_POST['email']))
	$email_value = htmlentities($_POST['email']); 

include("templates/header.inc.php");

	echo "<script type=\"text/javascript\">";
    echo  "var onloadCallback = function() {";
    echo     "grecaptcha.render('html_element', {";
    echo      "'sitekey' : '6LeJZ0QUAAAAACG4Cyf7SWBbO-mOwhIme-tZrLeD'";
    echo    "});";
    echo  "};";
    echo "</script>";

 echo "<div style=\"max-width: 330px;padding: 15px;margin: 0 auto;font-family: 'timeburner';\">";
 if(isset($_GET['redirect'])){
	echo "<form action=\"login.php?redirect= " . $_GET['redirect'] . " \" method=\"post\">";
}else{
	echo "<form action=\"login.php\" method=\"post\">";
 }
?>
	<h2 style="color: white;text-align:center;font-family: 'nextfont';" class="form-signin-heading">Login</h2>
	<p></p>
<?php 

	echo "<p style =\"color:white; \">" . $error_msg . "</p>";

/*<input name="email" id="inputEmail" style="border-radius: 5px;border-top:0px;border-left:0px;border-right:0px;width: 100%;height:34px;box-sizing: border-box;padding: 6px 12px;" placeholder="E-Mail oder Benutzername" value="<?php echo $email_value; ?>" required autofocus>
*/
?>
	<label  for="inputEmail" class="sr-only">E-Mail</label>
	<style>
		.inputBox {outline: 0 none;color:gray ;background-color: black;border-top: none;border-bottom: 2px solid gray;border-left: none;border-right: none;width: 100%;height:34px;box-sizing: border-box;padding: 6px 4px;}
		.inputBox:focus {outline: 0 none;border-bottom: 2px solid white;color:white;}
	</style>
	<input name="email" class="inputBox" id="inputEmail" placeholder="E-Mail oder Benutzername" value="<?php echo $email_value; ?>" required autofocus>
	
	<p></p>
	<label for="inputPassword" class="sr-only">Passwort</label>
	<input type="password" class="inputBox" name="passwort" id="inputPassword" placeholder="Passwort" required>
	
	<div class="checkbox">
	  <label style="color: white;">
		<input  type="checkbox" value="remember-me" name="angemeldet_bleiben" value="1" checked> Angemeldet bleiben
	  </label>
	</div>
	<div id="html_element"></div>
	<br>
	<input type="submit" style="background: white;color: black;border-radius: 0px;" value="Login" class="btn btn-lg btn-primary btn-block"/>
	<br>
	<a style="color: white;" href="passwortvergessen.php">Passwort vergessen</a>
  </form>
	<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
</div> <!-- /container -->
</body>
<?php 
include("templates/footer.inc.php")
?>
