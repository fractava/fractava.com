<head> 
	<title>FRACTAVA - Forum</title> 
<?php 
	session_start();
	require_once($_SERVER['DOCUMENT_ROOT'] . "/account/inc/config.inc.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/account/inc/functions.inc.php");
	include($_SERVER['DOCUMENT_ROOT'] . "/account/templates/header.inc.php");
	$user = check_user(false);
	require_once($_SERVER['DOCUMENT_ROOT'] . "/account/inc/blockedIPs.inc.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/account/templates/main_link.php");
	include($_SERVER['DOCUMENT_ROOT'] . "/account/templates/login_right_corner.inc.php");
	
	redirectToSSL();
?>
</head>
<body style = "background: black;">
<?php
account_right_corner("https://fractava.com/", $user['vorname']);
$sql = "SELECT id , title , creator_id , created_at FROM Forum_threads ORDER BY created_at ASC";

echo "<h1 style = \"color:white;text-align: center;font-family: 'nextfont';\">Forum</h1>";
echo "<br>";
if(is_checked_in()){
	
	echo "<a style = \"\" href= \"new_thread.php\">";
	echo "<div style = \"background-color:white;width: 75%;margin: 0 auto;border-radius: 12px;text-align: center;padding:1em;font-family: 'timeburner';\">";
	echo "<b style = \"color: black;\">Frage stellen</b></b>";
	echo "</div>";
	echo "</a>";
	echo "<br>";
}else {
	echo "<div style = \"background-color:white;width: 75%;margin: 0 auto;border-radius: 12px;text-align: center;padding:1em;font-family: 'timeburner';color:black;\">";
	echo "<a style = \"color:black; \" href = \"https://fractava.com/account/login.php?redirect=https://fractava.com/forum/forum.php\"> Um Einträge zu erstellen melde dich bitte an</a>";
	echo "</div>";
	echo "<br>";
	}
echo "<table style = \"background-color:white;width: 75%;margin: 0 auto;border-radius: 8px;\">";
echo "<th style = \"padding:6px; \">Titel</th>";
echo "<th style = \"padding:6px; \">erstellt am</th>";
echo "<th style = \"padding:6px; \">von</th>";
foreach ($pdo->query($sql) as $row) {
//echo "<div style= \"background-color:white;width: 75%;margin: 0 auto;border-radius: 12px;text-align: center;\">";
	echo "<tr>";
		
		echo "<td style = \"padding: 3px;\">";
		echo "<b> <a style = \"color:black;font-family: 'timeburner';font-weight: bold;\" href = \" view-thread.php?eintrag=" . $row['id'] . " \" > "  . $row['title'] . "</a></b>";
		echo "</td>";
		echo "<td style = \"padding: 3px;\">";
		echo date("d.m.y", strtotime($row["created_at"]));
		echo "</td>";
			
   		$sql = "SELECT Benutzername FROM users WHERE id = " . $row['creator_id'] . " LIMIT 1";
		foreach ($pdo->query($sql) as $user) {
		echo "<td style = \"padding: 3px;\">";
   		echo "<p>" . $user['Benutzername'] . "</p>";

		echo "</td>";
		}
	

//echo "</div>";

}

echo "</table>";


?>
</body>
