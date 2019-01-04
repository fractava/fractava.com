<?php 
	session_start();
	require_once($_SERVER['DOCUMENT_ROOT'] . "/account/inc/config.inc.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/account/inc/functions.inc.php");
	include($_SERVER['DOCUMENT_ROOT'] . "/account/templates/header.inc.php");
	$user = check_user(false);
	require_once($_SERVER['DOCUMENT_ROOT'] . "/account/inc/blockedIPs.inc.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/account/templates/main_link.php");
?>

<head>
	<title>FRACTAVA Blog</title>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-112803937-1"></script>
		<script>
  		window.dataLayer = window.dataLayer || [];
  		function gtag(){dataLayer.push(arguments);}
  		gtag('js', new Date());
  		gtag('config', 'UA-112803937-1');
	</script>
</head>


<body style="background-color: black;">
	
	<br>
	<?php
		$statement = $pdo->prepare("UPDATE Blog SET views = views + 1 WHERE id= :id");
		$statement->execute(array('id' => $_GET["eintrag"]));
		
		$sql = "SELECT id, Überschrift, Text FROM Blog WHERE id = " . $_GET["eintrag"] . " LIMIT 1";

		
		foreach ($pdo->query($sql) as $row) {
			echo "<h1 style = \"color:white;text-align: center;font-family: 'nextfont';\"> " . $row['Überschrift'] . "</h1>";
			echo "<br>";

			echo "<div style= \"background-color:white;width: 75%;margin: 0 auto;border-radius: 12px;text-align: center;padding:1em;font-family: 'timeburner';\">";
   			echo $row['Text'];
			echo "</div>";
		}
	?>
</body>
