<?php
	session_start();
	require_once($_SERVER['DOCUMENT_ROOT'] . "/account/inc/config.inc.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/account/inc/functions.inc.php");
	$user = check_user(true , "?redirect=http://fractava.com/admin/index.php");
	if($user["admin"] != "1"){
		die("Du bist kein Admin");
	}
?>
<html>
<head>
  <meta charset="UTF-8">

  <!-- PLEASE NO CHANGES BELOW THIS LINE (UNTIL I SAY SO) -->
  <script language="javascript" type="text/javascript" src="libraries/p5.js"></script>
  <script language="javascript" type="text/javascript" src="admin.js"></script>
  <!-- OK, YOU CAN MAKE CHANGES BELOW THIS LINE AGAIN -->

  <!-- This line removes any default padding and style. 
       You might only need one of these values set. -->
  <style> body {padding: 0; margin: 0;} </style>
</head>

<body>
</body>
</html>
