<head>
	<title>FRACTAVA - Blog</title>
<?php 
	session_start();
	require_once($_SERVER['DOCUMENT_ROOT'] . "/account/inc/config.inc.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/account/inc/functions.inc.php");
	include($_SERVER['DOCUMENT_ROOT'] . "/account/templates/header.inc.php");
	$user = check_user(false);
	require_once($_SERVER['DOCUMENT_ROOT'] . "/account/inc/blockedIPs.inc.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/account/templates/main_link.php");
?>


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
	
	<h1 style = "color:white;text-align: center;font-family: 'nextfont';">Blog</h1>
	<br>
	
	<?php
		$search_tag = $_GET["tag"];
		$nothing = "true";

		$sql2 = "SELECT id, name FROM Blog_tags ORDER by name";
		
		echo "<details style = \"text-align:center;border: 0px;\">";
  		echo "<summary style=\"color:white;outline: 0 none;\">Filter</summary>";
		foreach ($pdo->query($sql2) as $row) {
  		echo "<a style = \"color: white;font-family: 'timeburner';\" href = \"blog.php?tag=". $row['id'] . "\">" . $row['name'] . "</a><br>";
		}
		echo "</details><br>";

		if(!isset($_GET["tag"])){
			$sql = "SELECT id, Überschrift, Vorschau , tag1 , tag2 , tag3 , created_at FROM Blog ORDER by id DESC LIMIT 50";
		}else {
			$sql = "SELECT id, Überschrift, Vorschau , tag1 , tag2 , tag3 , created_at FROM Blog WHERE tag1 = " . $search_tag . " OR tag2 =  " . $search_tag . " OR tag3 =  " . $search_tag ." ORDER by id DESC LIMIT 50";
		}
		
		
		foreach ($pdo->query($sql) as $row) {
			$nothing = "false";
			echo "<div style= \"background-color:white;width: 75%;margin: 0 auto;border-radius: 12px;text-align: center;\">";
			echo "<b> <a style = \"color:black;font-family: 'timeburner';font-weight: bold;\" href = \" view-blog.php?eintrag=" . $row['id'] . " \" > " . $row['Überschrift'] . "</a></b>";
			echo "  ,   " . date("d.m.y", strtotime($row["created_at"]));
			echo "<p></p>";
			include("view_tags.php");
			
   			
   			echo "<p style = \"color:black;text-align: center;font-family: 'timeburner';\"> " . $row['Vorschau'] . "</p>";
			echo "</div>";
		}

		if($nothing == "true"){
		echo "<p style=\"color:white;text-align: center;font-family: 'timeburner';\">Keine Ergebnisse</p>";
		}
	?>
</body>
