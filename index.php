<?php
		if($_COOKIE["cookie_selection"] != ""){
			session_start();
		}
		require_once($_SERVER['DOCUMENT_ROOT'] . "/account/inc/config.inc.php");
		require_once($_SERVER['DOCUMENT_ROOT'] . "/account/inc/functions.inc.php");
			$user = check_user(false);
		include($_SERVER['DOCUMENT_ROOT'] . "/account/templates/login_right_corner.inc.php");
		account_right_corner("https://fractava.com/", $user['vorname']);
		require_once($_SERVER['DOCUMENT_ROOT'] . "/account/inc/blockedIPs.inc.php");

		redirectToSSL();
?>

<html>

	<head>
		<style>
#first {
	width: 100%;
	height: 100vh;
	background-color: black;
	text-align: center;
	float: center;
}

#first nav ul{
	display: inline-block;
	width: 100%;
}

#first nav a {
	margin: 16px;
}

#first h1 {
	color: white;
}

#first a {
	color: white;
}

#second {
	width: 100%;
	height: 100vh;
	background-color: white;
}

#second h1 {
	color: black;
}

#second a {
	color: black;
}

#second p {
	color: black;
}

#last {
	width: 100%;
	height: auto;
	background-color: black;
	text-align: center;
	display: flex;
    justify-content: center;
}

#last p{
	color: white;
}

#last h1 {
	color: white;
}


#last a {
	color: white;
	font-family: 'timeburner';
	font-size: 17;
	margin: 16px
}



.black {
  color: #000000;
}
.white {
  color: #FFFFFF;
}
		</style>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>'
		<?php
		if($_COOKIE["cookie_selection"] == "2"){
			//<!-- Global site tag (gtag.js) - Google Analytics -->
			echo '<script async src="https://www.googletagmanager.com/gtag/js?id=UA-112803937-1"></script>';
			echo '<script>';
			echo 'window.dataLayer = window.dataLayer || [];';
			echo 'function gtag(){dataLayer.push(arguments);}';
			echo "	gtag('js', new Date());";
			echo "	gtag('config', 'UA-112803937-1');";
			echo '</script>';
		}
	?>
		<link rel="stylesheet" href="https://fractava.com/style.css" type="text/css" />
		<title>FRACTAVA - Home</title>
		<link rel="shortcut icon" type="image/png" href="/favicon.png" />
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	</head>

	<body>
		<script src="https://fractava.com/hans.js"></script>
		<?php

			$statement = $pdo->prepare("SELECT DSVGO FROM users WHERE id = :id");
			$result = $statement->execute(array('id' => $user['id']));
			$DSVGO = $statement->fetch();

			if($DSVGO["DSVGO"] == "0"){
				//echo "<div style = \"position:fixed;width:100%;height:100%;background: rgba(255, 255, 255, .99);;\"></div>";
				echo "<div style=\"position:fixed;background-color: white;top:12.5%;left: 12.5%;width: 75%; height: 75%;border: 5px solid black;color: black;\">";
				echo "<p>Lies die <a href=\"https://fractava.com/policy.html\" target=\"_blank\">Datenschutzbedingungen</a> aufmerksam durch und klicke dann auf bestätigen.</p>";
				echo "<a style=\"position: absolute;bottom: 5%;width: 20%;left: 40%;background-color: white;border: 3px solid black;color: black;\" href=\"https://fractava.com/account/confirmDSVGO.php\">Bestätigen</a>";
				echo "</div>";
			}else{
				if($_COOKIE["cookie_selection"] == ""){
					//echo "cookie_selection not set";
					echo "<div style=\"position:fixed;background-color: white;top:12.5%;left: 12.5%;width: 75%; height: 75%;border: 5px solid black;color: black;float:center;\">";
						echo "<p>Cookie Einstellungen</p>";
						echo "<a href=\"https://fractava.com/cookie_selection.php?selection=0\"><div style = \"position: relative;left: 10%;font-size: 14px;height: 20%;width: 80%;border: 3px solid gray;border-radius: 5px;color: black;\">";
							echo "<p style=\"float: center;\">Gar keine (nicht empfohlen)</p>";
							echo "<p style=\"float: center;\">Die Seite wird nicht funktionieren !</p>";
						echo "</div></a>";
						echo "<br>";
						echo "<a href=\"https://fractava.com/cookie_selection.php?selection=1\"><div style = \"position: relative;left: 10%;font-size: 14px;height: 20%;width: 80%;border: 3px solid gray;border-radius: 5px;color: black;\">";
							echo "<p style=\"float: center;\">Nur funktionale (nicht empfohlen)</p>";
							echo "<p style=\"float: center;\">Nur die nötigsten Cookies werden abgelegt</p>";
						echo "</div></a>";
						echo "<br>";
						echo "<a href=\"https://fractava.com/cookie_selection.php?selection=2\"><div style = \"position: relative;left: 10%;font-size: 14px;height: 20%;width: 80%;border: 3px solid gray;border-radius: 5px;color: black;\">";
							echo "<p style=\"float: center;\">alle Cookies (empfohlen)</p>";
							echo "<p style=\"float: center;\">Empfohlen für beste Nutzererfahrung</p>";
						echo "</div></a>";
					echo "</div>";
				}
			}
		?>

		<div id="rnav">
			<ul>
				<li><a href="#first"><div class="sidebutton white">•</div></a></li>
				<li><a href="#second"><div class="sidebutton white">•</div></a></li>
			</ul>
		</div>

		<section id="first">
			<h1>FRACTAVA</h1>
			<nav>
				<ul>
					<li><a style="font-size: 32px;" href="#first">Home</a></div></li>

				</ul>

				<ul>
					<li><a style="font-size: 32px;" href="https://fractava.com/king-of-planets/">King of Planets</a></li>
				</ul>
				<ul>
					<li><a style="font-size: 32px;" href="blog/blog.php">Blog</a></li>
				</ul>
				<ul>
					<li><a style="font-size: 32px;" href="forum/forum.php">Forum</a></li>
				</ul>
			</nav>
			<div class="nextbutton"><a href="#second">▼</a></div>
		</section>

		<section id="second">
			<h1>ÜBER UNS</h1>
			<p>Spiele-Entwicklung und Gestaltung seit 2018</p>
		</section>

		<section id="last">
			<a href="impressum.html">Impressum</a>
			<a href="policy.html">Datenschutzerklärung</a>
		</section>


	</body>
</html>
