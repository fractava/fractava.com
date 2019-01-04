<?php
		session_start();
		require_once($_SERVER['DOCUMENT_ROOT'] . "/account/inc/config.inc.php");
		require_once($_SERVER['DOCUMENT_ROOT'] . "/account/inc/functions.inc.php");
		$user = check_user(false);
		require_once($_SERVER['DOCUMENT_ROOT'] . "/account/inc/blockedIPs.inc.php");
		include($_SERVER['DOCUMENT_ROOT'] . "/account/templates/login_right_corner.inc.php");
		
		redirectToSSL();
?>
<!DOCTYPE html>
<html>
	<style>
	#first {
	width: 100%;
	height: 100vh;
	background: url("KoP HTML.png") no-repeat center center;
	background-size: cover;
}

#first h1 {
	color: #ff5a02;
}

#first a {
	color: #ff5a02;
}

#first p {
	color: #ff5a02;
}

#second {
	width: 100%;
	height: 100vh;
	background-color: white;
}

#second h1 {
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
	/*float: center;*/
	display: flex;
    flex-direction: row;
    align-items: stretch;
    justify-content: center;
    /*Ich habe eine Flexbox benutzt da es moderner und einfacher ist - Florentin*/
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


.orange {
	color: #ff5a02;
}

.black {
	color: #000000;
}
.white {
	color: #ff5a02;
}
	</style>
	<head>
		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-112803937-1"></script>
		<script>
  			window.dataLayer = window.dataLayer || [];
  			function gtag(){dataLayer.push(arguments);}
  			gtag('js', new Date());
 			 gtag('config', 'UA-112803937-1');
		</script>

		<link rel="stylesheet" href="https://fractava.com/style.css" type="text/css" />
		<title>FRACTAVA - King of Planets</title>
		<link rel="shortcut icon" type="image/png" href="/favicon.png">
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		
	</head>
	
	<body>
		<?php
			require_once($_SERVER['DOCUMENT_ROOT'] . "/account/templates/main_link.php");
		?>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script src="hans.js"></script>
		<?php
			account_right_corner("http://fractava.com/king-of-planets/" , $user['vorname']);
		?>
		<div id="rnav">
			<ul>
				<li><a href="#first"><div class="sidebutton white">•</div></a></li>
				<li><a href="#second"><div class="sidebutton white">•</div></a></li>
			</ul>
		</div>
		
		<section id="first">
			<h1>KING OF PLANETS</h1>
			<p>Der Faire 2.5D Moba</p>
			<div class="nextbutton"><a href="#second">▼</a></div>
		</section>
		
		<section id="second">
			<h1>KEINE UPDATES</h1>
			<p>Momentan in Entwicklung</p>
		</section>

		<section id="last">
			<a href="../impressum.html">Impressum</a>
			<a href="../policy.html">Datenschutzerklärung</a>
		</section>
	</body>
</html>
