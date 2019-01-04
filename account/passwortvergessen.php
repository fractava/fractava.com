<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/account/templates/main_link.php");
?>
<body style="background-color: black;> </body>
<?php 
 //error_reporting(E_ALL);
session_start();

require_once("inc/config.inc.php");
require_once("inc/functions.inc.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/account/inc/blockedIPs.inc.php");


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';

include("templates/header.inc.php");
?>
 <div class="container small-container-330">
	<h2 style="color: white;text-align:center;">Passwort vergessen</h2><br>


<?php 
$showForm = true;
 
if(isset($_GET['send']) ) {
	if(!isset($_POST['email']) || empty($_POST['email'])) {
		$error = "<b>Bitte eine E-Mail-Adresse eintragen</b>";
	} else {
		$statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
		$result = $statement->execute(array('email' => $_POST['email']));
		$user = $statement->fetch();		
 
		if($user === false) {
			$error = "<b>Kein Benutzer gefunden</b>";
		} else {
			
			$passwortcode = random_string();
			$statement = $pdo->prepare("UPDATE users SET passwortcode = :passwortcode, passwortcode_time = NOW() WHERE id = :userid");
			$result = $statement->execute(array('passwortcode' => sha1($passwortcode), 'userid' => $user['id']));
			
			$empfaenger = $user['email'];
			$betreff = "Neues Passwort für deinen Account auf Fractava.com"; //Ersetzt hier den Domain-Namen
			$from = "From: Vorname Nachname <absender@domain.de>"; //Ersetzt hier euren Name und E-Mail-Adresse
			$url_passwortcode = getSiteURL().'passwortzuruecksetzen.php?userid='.$user['id'].'&code='.$passwortcode; //Setzt hier eure richtige Domain ein
			$text = 'Hallo '.$user['vorname'].',
für deinen Account auf Fractava.com wurde nach einem neuen Passwort gefragt. Um ein neues Passwort zu vergeben, drücke innerhalb der nächsten 24 Stunden den folgenden Button: 
<a href='.$url_passwortcode.'><input type="button" value="neues Passwort setzen"></a> <br>
 
Sollte dir dein Passwort wieder eingefallen sein oder hast du dies nicht angefordert, so bitte ignoriere diese E-Mail.
 
Viele Grüße,
dein FRACTAVA-Team';
			
			






$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    //Server settings
    $mail->SMTPDebug = 0;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = '***REMOVED***';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'support@fractava.com';                 // SMTP username   
    $mail->Password = '***REMOVED***';                        // SMTP password
    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 465;                                    // TCP port to connect to
    $mail->CharSet = 'utf-8'; 

    //Recipients
    $mail->setFrom('support@fractava.com', 'Fractava');
    $mail->addAddress($empfaenger);               // Name is optional
    //$mail->addReplyTo('support@fractava.com', 'Information');
    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $betreff;
    $mail->Body    = $text;

    $mail->send();

    echo "Ein Link um dein Passwort zurückzusetzen wurde an deine E-Mail-Adresse gesendet.";	
    $showForm = false;
} catch (Exception $e) {
    echo 'E-mail konnte nicht gesendet werden. Versuchen sie es später noch einmal.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
}
 
			
		}
	}
}
 
if($showForm):
?> 
	<p style="color: white;">Gib hier deine E-Mail-Adresse ein, um ein neues Passwort anzufordern.</p><br>
	 
	<?php
	if(isset($error) && !empty($error)) {
		echo "<p style=" . "\"color: white;\">" . $error . "</p>";
	}
	
	?>
	<form style="color:white;" action="?send=1" method="post">
		<label  for="inputEmail">E-Mail</label>
		<input style="border-radius: 5px;border-top:0px;border-bottom:0px;border-left:0px;border-right:0px;width: 100%;height:34px;box-sizing: border-box;padding: 6px 12px;" placeholder="E-Mail" name="email" type="email" value="<?php echo isset($_POST['email']) ? htmlentities($_POST['email']) : ''; ?>" required>
		<br>
<br>
		<input  class="btn btn-lg btn-primary btn-block" style="background: white;color: black" type="submit" value="Neues Passwort">
	</form> 
<?php
endif; //Endif von if($showForm)
?>

</div> <!-- /container -->
 

<?php 
include("templates/footer.inc.php")
?>
