<?php
/**
 * A complete login script with registration and members area.
 *
 * @author: Nils Reimers / http://www.php-einfach.de/experte/php-codebeispiele/loginscript/
 * @license: GNU GPLv3
 */
include_once("password.inc.php");

/**
 * Checks that the user is logged in. 
 * @return Returns the row of the logged in user
 */
function check_user($force ,$logingetParameter) {
	global $pdo;
	
	if(!isset($_SESSION['userid']) && isset($_COOKIE['identifier']) && isset($_COOKIE['securitytoken'])) {
		$identifier = $_COOKIE['identifier'];
		$securitytoken = $_COOKIE['securitytoken'];
		
		$statement = $pdo->prepare("SELECT * FROM securitytokens WHERE identifier = ?");
		$result = $statement->execute(array($identifier));
		$securitytoken_row = $statement->fetch();
	
		if(sha1($securitytoken) !== $securitytoken_row['securitytoken']) {
			//Vermutlich wurde der Security Token gestohlen
			//Hier ggf. eine Warnung o.ä. anzeigen
			
		} else { //Token war korrekt
			//Setze neuen Token
			$neuer_securitytoken = random_string();
			$insert = $pdo->prepare("UPDATE securitytokens SET securitytoken = :securitytoken WHERE identifier = :identifier");
			$insert->execute(array('securitytoken' => sha1($neuer_securitytoken), 'identifier' => $identifier));
			setcookie("identifier",$identifier,time()+(3600*24*365)); //1 Jahr Gültigkeit
			setcookie("securitytoken",$neuer_securitytoken,time()+(3600*24*365)); //1 Jahr Gültigkeit
			
			//Logge den Benutzer ein
			$_SESSION['userid'] = $securitytoken_row['user_id'];
		}
	}
	
	
	if(!isset($_SESSION['userid'])) {
		//echo $logingetParameter;
		if($force == true){
			if(!isset($logingetParameter)){
				die("Bitte zuerst <a style = \" font-family: 'timeburner'; \" href=\"http://fractava.com/account/login.php\">einloggen</a>");
			}else{
				die("Bitte zuerst <a style = \" font-family: 'timeburner'; \" href=\" http://fractava.com/account/login.php" . $logingetParameter . " \">einloggen</a>");
			}
		}
	}
	

	$statement = $pdo->prepare("SELECT * FROM users WHERE id = :id");
	$result = $statement->execute(array('id' => $_SESSION['userid']));
	$user = $statement->fetch();
	return $user;
}
function comments_blocked(){
	global $pdo;
	$statement = $pdo->prepare("SELECT comments_blocked FROM users WHERE id = :id");
	$result = $statement->execute(array('id' => $_SESSION['userid']));
	$comments_blocked = $statement->fetch();
	//var_dump((int)$comments_blocked["comments_blocked"]);
	return((int)$comments_blocked["comments_blocked"] !== 0);
}
function check_token(String $identifier, String $securitytoken) {
	global $pdo;
	
	if(!isset($_SESSION['userid']) && isset($identifier) && isset($securitytoken)) {
		
		$statement = $pdo->prepare("SELECT * FROM securitytokens WHERE identifier = ?");
		$result = $statement->execute(array($identifier));
		$securitytoken_row = $statement->fetch();
	
		if(sha1($securitytoken) !== $securitytoken_row['securitytoken']) {
			//Vermutlich wurde der Security Token gestohlen
			//Hier ggf. eine Warnung o.ä. anzeigen
			echo "[false]";
		} else { //Token war korrekt
			//Setze neuen Token
			echo "[true]";
			echo "|";
			$neuer_securitytoken = random_string();
			$insert = $pdo->prepare("UPDATE securitytokens SET securitytoken = :securitytoken WHERE identifier = :identifier");
			$insert->execute(array('securitytoken' => sha1($neuer_securitytoken), 'identifier' => $identifier));
			echo "[" . $neuer_securitytoken . "]";
			//Logge den Benutzer ein
			//$_SESSION['userid'] = $securitytoken_row['user_id'];
		}
	}
	
	
	if(!isset($_SESSION['userid'])) {
		//echo $logingetParameter;
		if($force == true){
			
				//die("Bitte zuerst <a style = \" font-family: 'timeburner'; \" href=\"http://fractava.com/account/login.php\">einloggen</a>");
			
				//die("Bitte zuerst <a style = \" font-family: 'timeburner'; \" href=\" http://fractava.com/account/login.php" . $logingetParameter . " \">einloggen</a>");
			
		}
	}
	

	$statement = $pdo->prepare("SELECT * FROM users WHERE id = :id");
	$result = $statement->execute(array('id' => $_SESSION['userid']));
	$user = $statement->fetch();
	return $user;
}

/**
 * Returns true when the user is checked in, else false
 */
function is_checked_in() {
	return isset($_SESSION['userid']);
}
 
/**
 * Returns a random string
 */
function random_string() {
	if(function_exists('openssl_random_pseudo_bytes')) {
		$bytes = openssl_random_pseudo_bytes(16);
		$str = bin2hex($bytes); 
	} else if(function_exists('mcrypt_create_iv')) {
		$bytes = mcrypt_create_iv(16, MCRYPT_DEV_URANDOM);
		$str = bin2hex($bytes); 
	} else {
		//Replace your_secret_string with a string of your choice (>12 characters)
		$str = md5(uniqid('your_secret_string', true));
	}	
	return $str;
}

/**
 * Returns the URL to the site without the script name
 */
function getSiteURL($withoutProtocol) {
	$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
	if(withoutProtocol){
		return $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/';
	}else{
		return $protocol.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/';
	}
}
function isSSL(){
	return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? true : false;
}

function redirectToSSL(){
	//if(isSSL() == false){
			//header("location:https://" . getSiteUrl(true));
	//}
	$use_sts = TRUE;

	if ($use_sts && isset($_SERVER['HTTPS'])) {
		header('Strict-Transport-Security: max-age=500');
	} elseif ($use_sts && !isset($_SERVER['HTTPS'])) {
		header('Status-Code: 301');
		header('Location: https://'.$_SERVER["HTTP_HOST"].$_SERVER['REQUEST_URI']);
	}
}

/**
 * Outputs an error message and stops the further exectution of the script.
 */
function error($error_msg) {
	include("templates/header.inc.php");
	include("templates/error.inc.php");
	include("templates/footer.inc.php");
	exit();
}
