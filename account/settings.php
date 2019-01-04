<?php
session_start();
require_once("inc/config.inc.php");
require_once("inc/functions.inc.php");

$redirect = $_GET["redirect"];
//Überprüfe, dass der User eingeloggt ist
//Der Aufruf von check_user() muss in alle internen Seiten eingebaut sein
$user = check_user(true);
require_once($_SERVER['DOCUMENT_ROOT'] . "/account/inc/blockedIPs.inc.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/account/templates/main_link.php");
include("templates/header.inc.php");

if(isset($_GET['save'])) {
	$save = $_GET['save'];
	
	if($save == 'personal_data') {
		$vorname = trim($_POST['vorname']);
		$nachname = trim($_POST['nachname']);
		
		if($vorname == "" || $nachname == "") {
			$error_msg = "Bitte Vor- und Nachname ausfüllen.";
		} else {
			$statement = $pdo->prepare("UPDATE users SET vorname = :vorname, nachname = :nachname, updated_at=NOW() WHERE id = :userid");
			$result = $statement->execute(array('vorname' => $vorname, 'nachname'=> $nachname, 'userid' => $user['id'] ));
			
			$success_msg = "Daten erfolgreich gespeichert.";
			header("location: http://fractava.com/index.php");
		}
	} else if($save == 'email') {
		$passwort = $_POST['passwort'];
		$email = trim($_POST['email']);
		$email2 = trim($_POST['email2']);
		
		if($email != $email2) {
			$error_msg = "Die eingegebenen E-Mail-Adressen stimmten nicht überein.";
		} else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$error_msg = "Bitte eine gültige E-Mail-Adresse eingeben.";
		} else if(!password_verify($passwort, $user['passwort'])) {
			$error_msg = "Bitte korrektes Passwort eingeben.";
		} else {
			$statement = $pdo->prepare("UPDATE users SET email = :email WHERE id = :userid");
			$result = $statement->execute(array('email' => $email, 'userid' => $user['id'] ));
				
			$success_msg = "E-Mail-Adresse erfolgreich gespeichert.";
			header("location: http://fractava.com/index.php");
		}
		
	} else if($save == 'passwort') {
		$passwortAlt = $_POST['passwortAlt'];
		$passwortNeu = trim($_POST['passwortNeu']);
		$passwortNeu2 = trim($_POST['passwortNeu2']);
		
		if($passwortNeu != $passwortNeu2) {
			$error_msg = "Die eingegebenen Passwörter stimmten nicht überein.";
		} else if($passwortNeu == "") {
			$error_msg = "Das Passwort darf nicht leer sein.";
		} else if(!password_verify($passwortAlt, $user['passwort'])) {
			$error_msg = "Bitte korrektes Passwort eingeben.";
		} else {
			$passwort_hash = password_hash($passwortNeu, PASSWORD_DEFAULT);
				
			$statement = $pdo->prepare("UPDATE users SET passwort = :passwort WHERE id = :userid");
			$result = $statement->execute(array('passwort' => $passwort_hash, 'userid' => $user['id'] ));
				
			$success_msg = "Passwort erfolgreich gespeichert.";
			echo "<p style =\"font-size:200px;color:white;\">" . $redirect . "</p>";
			if($redirect != ""){
				header("location: " . $redirect);
			}else{
				header("location: http://fractava.com/index.php");
			}
		}
		
	}
}

$user = check_user();

?>
<body style = "background-color:black;">
<div class="container main-container">

<h1 style = "color: white;">Einstellungen</h1>
<br>
<?php 
if(isset($success_msg) && !empty($success_msg)):
?>
	<div class="alert alert-success">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	  	<?php echo $success_msg; ?>
	</div>
<?php 
endif;
?>

<?php 
if(isset($error_msg) && !empty($error_msg)):
?>
	<div class="alert alert-danger">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	  	<?php echo $error_msg; ?>
	</div>
<?php 
endif;
?>

<div>
	<style>
		.inputBox {outline: 0 none;color:gray ;background-color: black;border-top: none;border-bottom: 2px solid gray;border-left: none;border-right: none;width: 100%;height:34px;box-sizing: border-box;padding: 6px 4px;}
		.inputBox:focus {outline: 0 none;border-bottom: 2px solid white;color:white;}
	</style>
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#data" aria-controls="home" role="tab" data-toggle="tab" style = "color:gray;border-radius: 0px;">Persönliche Daten</a></li>
    <li role="presentation" ><a href="#email" aria-controls="profile" role="tab" data-toggle="tab" style = "color:gray;border-radius: 0px;">E-Mail</a></li>
    <li role="presentation" ><a href="#passwort" aria-controls="messages" role="tab" data-toggle="tab" style = "color:gray;border-radius: 0px;">Passwort</a></li>
    <li role="presentation" ><a href="#avatar" aria-controls="messages" role="tab" data-toggle="tab" style = "color:gray;border-radius: 0px;">Profilbild</a></li>
  </ul>
	
  <!-- Persönliche Daten-->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="data">
    	<br>
    	<form action="?save=personal_data" method="post" class="form-horizontal">
    		<div class="form-group">
    			<label for="inputVorname" class="col-sm-2 control-label" style = "color:white;">Vorname</label>
    			<div class="col-sm-10">
    				<input class="inputBox" id="inputVorname" name="vorname" type="text" value="<?php echo htmlentities($user['vorname']); ?>" required autofocus>
    			</div>
    		</div>
    		
    		<div class="form-group">
    			<label for="inputNachname" class="col-sm-2 control-label" style = "color:white;">Nachname</label>
    			<div class="col-sm-10">
    				<input class="inputBox" id="inputNachname" name="nachname" type="text" value="<?php echo htmlentities($user['nachname']); ?>" required>
    			</div>
    		</div>
    		
    		<div class="form-group">
			    <div class="col-sm-offset-2 col-sm-10">
			      <button  type="submit" class="btn" style = "border-radius: 0px;color:black; background-color: white;">Speichern</button>
			    </div>
			</div>
    	</form>
    	<br>
    	<br>
		
    </div>
    
    <!-- Änderung der E-Mail-Adresse -->
    <div role="tabpanel" class="tab-pane" id="email">
    	<br>
    	<p style = "color:white;">Zum Änderen deiner E-Mail-Adresse gib bitte dein aktuelles Passwort sowie die neue E-Mail-Adresse ein.</p>
    	<form action="?save=email" method="post" class="form-horizontal">
    		<div class="form-group">
    			<label for="inputPasswort" class="col-sm-2 control-label" style = "color:white;">Passwort</label>
    			<div class="col-sm-10">
    				<input class="inputBox" id="inputPasswort" name="passwort" type="password" required>
    			</div>
    		</div>
    		
    		<div class="form-group">
    			<label for="inputEmail" class="col-sm-2 control-label" style = "color:white;">E-Mail</label>
    			<div class="col-sm-10">
    				<input class="inputBox" id="inputEmail" name="email" type="email" value="<?php echo htmlentities($user['email']); ?>" required>
    			</div>
    		</div>
    		
    		
    		<div class="form-group">
    			<label for="inputEmail2" class="col-sm-2 control-label" style = "color:white;">E-Mail (wiederholen)</label>
    			<div class="col-sm-10">
    				<input class="inputBox" id="inputEmail2" name="email2" type="email" required>
    			</div>
    		</div>
    		
    		<div class="form-group">
			    <div class="col-sm-offset-2 col-sm-10">
			      <button  type="submit" class="btn" style = "color:black; background-color: white;">Speichern</button>
			    </div>
			</div>
    	</form>
    </div>
    
    <!-- Änderung des Passworts -->
    <div role="tabpanel" class="tab-pane" id="passwort">
    	<br>
    	<p style = "color:white;">Zum Änderen deines Passworts gib bitte dein aktuelles Passwort sowie das neue Passwort ein.</p>
			<form action="?save=passwort" method="post" class="form-horizontal">
    		<div class="form-group">
    			<label for="inputPasswort" class="col-sm-2 control-label" style = "color:white;">Altes Passwort</label>
    			<div class="col-sm-10">
    				<input class="inputBox" id="inputPasswort" name="passwortAlt" type="password" required>
    			</div>
    		</div>
    		
    		<div class="form-group">
    			<label for="inputPasswortNeu" class="col-sm-2 control-label" style = "color:white;">Neues Passwort</label>
    			<div class="col-sm-10">
    				<input class="inputBox" id="inputPasswortNeu" name="passwortNeu" type="password" required>
    			</div>
    		</div>
    		
    		
    		<div class="form-group">
    			<label for="inputPasswortNeu2" class="col-sm-2 control-label" style = "color:white;">Neues Passwort (wiederholen)</label>
    			<div class="col-sm-10">
    				<input class="inputBox" id="inputPasswortNeu2" name="passwortNeu2" type="password" required>
    			</div>
    		</div>
    		
    		<div class="form-group">
			    <div class="col-sm-offset-2 col-sm-10">
			      <button  type="submit" class="btn" style = "color:black; background-color: white;">Speichern</button>
			    </div>
			</div>
    	</form>
    </div>
    
    <div role="tabpanel" class="tab-pane" id="avatar">
		<br>
		<div style= "width: 75%;margin: 0 auto;border-radius: 12px;text-align: center;padding:1em;font-family: 'timeburner';">
			<form action="http://fractava.com/avatar.php?type=image" method="post" enctype="multipart/form-data">
				<input style = "display: inline;color:white;" type="file" name="datei">
				<input style = "background-color: white;" type="submit" value="Hochladen">
		</div>
		<p style ="text-align:center;"><a style="color:white;" href="https://fractava.com/PixelArtonline/">oder online gestalten</a></p>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<!-- <button  type="submit" class="btn" style = "color:black; background-color: white;">Speichern</button> -->
			</div>
		</div>
    	</form>
    </div>
  </div>

</div>


</div>
</body>
<?php 
include("templates/footer.inc.php")
?>
