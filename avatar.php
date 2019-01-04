<?php 
	session_start();
	require_once($_SERVER['DOCUMENT_ROOT'] . "/account/inc/config.inc.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/account/inc/functions.inc.php");
	//include($_SERVER['DOCUMENT_ROOT'] . "/account/templates/header.inc.php");
	$user = check_user(true , "?redirect=http://fractava.com/avatar.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/account/inc/blockedIPs.inc.php");
	//require_once($_SERVER['DOCUMENT_ROOT'] . "/account/templates/main_link.php");
?>
<?php
//file_put_contents ("/var/www/html/AvatarLog.txt", $_POST["pixeldata"]);
if($_GET["type"] == "pixelartonline"){
	
	$statement = $pdo->prepare("UPDATE users SET avatar = :data, avatar_type = :type WHERE id = :userid");
	$result = $statement->execute(array('type' => "PixelArtOnline" ,'data' => $_POST["pixeldata"], 'userid' => $user['id'] ));
	
	echo ("ready");
}else if($_GET["type"] == "image"){
$upload_folder = 'profile-images/'; //Das Upload-Verzeichnis
$filename = pathinfo($_FILES['datei']['name'], PATHINFO_FILENAME);
$extension = strtolower(pathinfo($_FILES['datei']['name'], PATHINFO_EXTENSION));
 
 
//Überprüfung der Dateiendung
$allowed_extensions = array('png', 'jpg', 'jpeg');
if(!in_array($extension, $allowed_extensions)) {
 die("Ungültige Dateiendung. Nur png, jpg und jpeg Dateien sind erlaubt");
}
 
//Überprüfung der Dateigröße
$max_size = 3*1024*1024; //3 MB
if($_FILES['datei']['size'] > $max_size) {
 die("Bitte keine Dateien größer 3MB hochladen");
}
 
//Überprüfung dass das Bild keine Fehler enthält
if(function_exists('exif_imagetype')) { //Die exif_imagetype-Funktion erfordert die exif-Erweiterung auf dem Server
 $allowed_types = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
 $detected_type = exif_imagetype($_FILES['datei']['tmp_name']);
 if(!in_array($detected_type, $allowed_types)) {
 die("Nur der Upload von Bilddateien ist gestattet");
 }
}
 
//Pfad zum Upload
$new_path = $upload_folder.$user['id'].'.'.$extension;

//Alles okay, verschiebe Datei an neuen Pfad
$statement = $pdo->prepare("SELECT avatar_type FROM users WHERE id = :userid LIMIT 1");
$statement->execute(array("userid" => $user['id']));
while($avatar_type = $statement->fetch()) {
	unlink($_SERVER['DOCUMENT_ROOT'] . "/profile-images/" . $user["id"] . $avatar_type["avatar_type"]);
}

move_uploaded_file($_FILES['datei']['tmp_name'], $new_path);
$statement = $pdo->prepare("UPDATE users SET avatar_type = :extension WHERE id = :userid ");
$statement->execute(array("extension" => "." . $extension , "userid" => $user["id"]));
header("location: http://fractava.com/account/settings.php");
//exit;
}

?>
