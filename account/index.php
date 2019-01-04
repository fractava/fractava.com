<?php 
session_start();
require_once("inc/config.inc.php");
require_once("inc/functions.inc.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/account/inc/blockedIPs.inc.php");
include("templates/header.inc.php")
?>

  

    

   
    <br>
      <div class="container" style ="text-align: center;">
        <p><a class="btn btn-primary btn-lg" href="login.php" role="button">Einloggen</a></p>
	<p><a class="btn btn-primary btn-lg" href="register.php" role="button">Jetzt registrieren</a></p>
      </div>
    
<?php 
include("templates/footer.inc.php")
?>
    
