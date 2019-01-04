<?php 
	session_start();
	require_once($_SERVER['DOCUMENT_ROOT'] . "/account/inc/config.inc.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/account/inc/functions.inc.php");
	include($_SERVER['DOCUMENT_ROOT'] . "/account/templates/header.inc.php");
	$user = check_user(false);
?>
<script>
			/* When the user clicks on the button, 
			toggle between hiding and showing the dropdown content */
			function myFunction(id) {
				document.getElementById(id).classList.toggle("show");
			}

			// Close the dropdown menu if the user clicks outside of it
			window.onclick = function(event) {
			if (!event.target.matches('.dropbtn')) {

				var dropdowns = document.getElementsByClassName("dropdown-content");
				var i;
				for (i = 0; i < dropdowns.length; i++) {
				var openDropdown = dropdowns[i];
				if (openDropdown.classList.contains('show')) {
					openDropdown.classList.remove('show');
				}
				}
			}
			}
</script>
<style>
	/* Dropdown Button */
	.dropbtn {
		outline: 0 none;
		background: url(more_vert_black.svg);
		background-repeat: no-repeat;
		background-position: center center;
		//color: white;
		padding: 16px;
		font-size: 16px;
		border: none;
		cursor: pointer;
	}

	/* Dropdown button on hover & focus */
	.dropbtn:hover, .dropbtn:focus {
		//background-color: #2980B9;
	}

	/* The container <div> - needed to position the dropdown content */
	.dropdown {
		float: right;
		position: relative;
		display: inline-block;
	}

	/* Dropdown Content (Hidden by Default) */
	.dropdown-content {
		right:0;
		display: none;
		position: absolute;
		background-color: #f1f1f1;
		//min-width: 160px;
		box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
		z-index: 1;
	}

	/* Links inside the dropdown */
	.dropdown-content a {
		color: black;
		padding: 12px 16px;
		text-decoration: none;
		display: block;
	}

	/* Change color of dropdown links on hover */
	.dropdown-content a:hover {background-color: #ddd}

	/* Show the dropdown menu (use JS to add this class to the .dropdown-content container when the user clicks on the dropdown button) */
	.show {display:block;}
	.textBoxCustom{outline: 0 none;box-sizing: border-box;padding: 6px 12px;border: none;border-bottom: 2px solid gray;}
	.textBoxCustom:focus{border-bottom: 2px solid black;}
	.ButtonCustom{background: white;color: black;border:2px solid black;}
	.ButtonCustom:hover{background: black;color: white;}
</style>
<head>
	<title>FRACTAVA Blog</title>
	<?php
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
	
	<a href= "http://fractava.com/forum/forum.php"><h3 style = "color: white;text-align: center;">Forum</h3></a>
	<br>
	<?php
	include($_SERVER['DOCUMENT_ROOT'] . "/account/templates/login_right_corner.inc.php");
	
	
	$statement = $pdo->prepare("SELECT COUNT(*) AS count FROM Forum_threads WHERE id = :id");
	$result = $statement->execute(array('id' => $_GET["eintrag"]));
	$count = $statement->fetch();

	if($count["count"] == "0"){
		account_right_corner("http://fractava.com/forum/forum.php", $user['vorname']);
		echo "<b><p style = \" text-align: center;color:white; \">Eintrag nicht gefunden</p></b>";
	}else{
		account_right_corner("http://fractava.com/forum/view-thread.php?eintrag=" . $_GET["eintrag"], $user['vorname']);
		
		$statement = $pdo->prepare("UPDATE Forum_threads SET views = views + 1 WHERE id= :id");
		$statement->execute(array('id' => $_GET["eintrag"]));
		
		$statement = $pdo->prepare("SELECT closed , id , title , creator_id , created_at FROM Forum_threads WHERE id = :thread_id" );
		$statement->execute(array("thread_id" => $_GET["eintrag"]));
		$thread = $statement->fetch();
			echo "<h1 style = \"color:white;text-align: center;font-family: 'nextfont';\">" . $thread['title'] . "			";
			if($thread["closed"] == 1){
				echo "[CLOSED]";
			}
			echo "</h1>";
			echo "<br>";
		
		$statement = $pdo->prepare("SELECT post_id , user_id , thread_id , Text FROM Forum_posts WHERE thread_id = :thread_id AND deleted = 0");
		$statement->execute(array("thread_id" => $_GET["eintrag"]));
		while($row = $statement->fetch()) {
			echo "<div style= \"background-color:white;width: 75%;margin: 0 auto;border-radius: 12px;text-align: center;padding:1em;font-family: 'timeburner';\">";
			echo "<table style = \" width: 100%;\">";
			echo "<tr style = \"\">";
			
			
			$statement2 = $pdo->prepare("SELECT Benutzername FROM users WHERE id = :userid LIMIT 1");
			$statement2->execute(array("userid" => $row['user_id']));
			while($user = $statement2->fetch()) {
				echo "<td style = \" width: 10%;\">";
   				echo "<p style = \" text-align: center; \">" . htmlentities($user['Benutzername']) . "</p>";
   			}

   			$statement3 = $pdo->prepare("SELECT avatar_type FROM users WHERE id = :userid LIMIT 1");
   			$statement3->execute(array("userid" => $row['user_id']));
   			$avatar_type = $statement3->fetch();
   			
   			if(strcmp($avatar_type["avatar_type"],"PixelArtOnline") == 0){
					echo "<img src= \"https://fractava.com/PixelArtAvatar.php?userid=" . $row['user_id'] . "\" alt= \"Account \" style= \"width:70%;float: center;image-rendering: pixelated;image-rendering: -moz-crisp-edges; \">";
			}else if(file_exists("/var/www/html/profile-images/". $row['user_id'] . $avatar_type["avatar_type"])){
					echo "<img src= \"https://fractava.com/profile-images/" . $row['user_id'] . $avatar_type["avatar_type"] . "\" alt= \"Account \" style= \"width:70%;float: center; \">";
			}else{
				echo "<img src= \"account.svg\" alt= \"Account \" style= \"width:70%;float: center; \">";
			}
			
			echo "</td>";
			?>
			
			<?php
			echo "<div style = \"width:100%;height:2.3em;\">";
			if($row['user_id'] == $_SESSION['userid']){
				echo "<div class=\"dropdown\">";
					echo "<button style=\"height: 100%;\" onclick=\"myFunction(" . $row['post_id'] . ")\" class=\"dropbtn\"></button>";
					echo "<div id=\"" . $row['post_id'] . "\" class=\"dropdown-content\">";
						echo "<a href=\"#\">bearbeiten</a>";
						if($row['post_id'] != 1){
							echo "<a href=\"delete_post.php?thread_id=" . $_GET["eintrag"] . "&post_id=" . $row['post_id'] . "\">löschen</a>";
						}
					echo"</div>";
				echo "</div>";
				if($row['post_id'] == 1){
					echo"<button style=\"float:right;background-color:white;border: 0;height:100%\" onclick=\"window.location.href='close_thread.php'\">Thread schließen</button>";
				}
			}
			echo "</div>";
			echo "<td style = \"width: 5%;\">";
			echo "</td>";
			echo "<td style = \"width: 85%;\">";
   			echo "<p style = \"text-align: left; \">" . nl2br(htmlentities($row['Text'])) . "</p>";
			
			echo "</td>";
			
			echo "</tr>";
			
			echo "</table>";
			echo "</div>";
			echo "<br>";
			
		}
			echo "<div style= \"background-color:white;width: 75%;margin: 0 auto;border-radius: 12px;text-align: center;padding:1em;font-family: 'timeburner';\">";
			if(is_checked_in()){
				if(comments_blocked()){
					echo "<b><p>Antworten ist für deinen Account gesperrt</p></b>";
				}elseif($thread["closed"] == 1){
					echo "<b><p>Dieser Forum Eintrag ist geschlossen</p></b>";
				}else{
				echo "<details style = \"text-align:center;border: 0px;outline: 0 none;\">";
				echo "<summary style =\"outline: 0 none; \">Antworten</summary>";
					echo "<form action=\"new_post.php?thread_id=" . $_GET["eintrag"] . "\" method=\"post\">";
						echo "<textarea class = \"textBoxCustom\" name=\"text\" rows=\"7\" placeholder=\"Text\" style=\"width: 100%;\"></textarea>";
						echo "<input type=\"submit\" style=\"width: 100%;height: 3em;border-radius: 0px;outline: 0 none;\" value=\"Posten\" class=\"ButtonCustom\"/>";
					echo "</form>";
				echo "</details>";
			}
			}else{
			echo "<p>Zum Antworten bitte <a href = \"https://fractava.com/account/login.php?redirect=https://fractava.com/forum/view-thread.php?eintrag=" . $_GET["eintrag"] . " \">anmelden</a></p>";
			}
			echo "</div>";
			echo "<br>";
		}
	?>
</body>
