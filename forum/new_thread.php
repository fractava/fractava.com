<head> 
	<title>FRACTAVA - Forum</title> 
<?php 
	session_start();
	require_once($_SERVER['DOCUMENT_ROOT'] . "/account/inc/config.inc.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/account/inc/functions.inc.php");
	include($_SERVER['DOCUMENT_ROOT'] . "/account/templates/header.inc.php");
	$user = check_user(true , "?redirect=http://fractava.com/forum/new_thread.php");
	
	require_once($_SERVER['DOCUMENT_ROOT'] . "/account/inc/blockedIPs.inc.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/account/templates/main_link.php");
?>

</head>
<body style = "background: black;">
	<?php
		if(isset($_POST['title']) && isset($_POST['description'])){
			$title = $_POST['title'];
			$description = $_POST['description'];
			
			//Thread
			$statement = $pdo->prepare("INSERT INTO Forum_threads (title ,creator_id) VALUES (:title, :creator_id)");
			$result = $statement->execute(array('title' => $title , 'creator_id' => $user['id']));
			
			//Thread ID
			$statement = $pdo->prepare("SELECT id FROM Forum_threads WHERE title = :title AND creator_id = :creatorid ORDER BY created_at DESC LIMIT 1");
			$statement->execute(array("title" => $title , "creatorid" => $user['id']));
			while($row = $statement->fetch()) {
				$thread_id = $row["id"];
			}
			
			//Post
			$statement = $pdo->prepare("INSERT INTO Forum_posts ( post_id , text , thread_id ,user_id) VALUES (:post_id , :text , :thread_id, :creator_id)");
			$result = $statement->execute(array('post_id' => 1 , 'text' => $description , 'thread_id' => $thread_id , 'creator_id' => $user['id']));
			echo "<p style = \"color:white;\">Forum Eintrag erstellt : <a style = \"color:white; \" href = \"view-thread.php?eintrag=" . $thread_id . "\">Anschauen</a></p>";
			exit;
		}
	
	?>
	
	
	
<h1 style="color: white;text-align:center;font-family: 'nextfont';">Forumeintrag erstellen</h1>
<br>
<div style = "border-radius: 12px;width:75%;text-align: center;margin: 0 auto;font-family: 'timeburner';">
	<form action="new_thread.php" method="post">
		<input name="title" id="inputTitle" style="border-radius: 5px;border-top:0px;border-left:0px;border-right:0px;width: 100%;height:34px;box-sizing: border-box;padding: 6px 12px;" placeholder="Titel oder Problem" required autofocus>
		<br></br>
		<textarea name="description" rows="7" placeholder="Beschreibung" style="border-radius: 5px;border-top:0px;border-left:0px;border-right:0px;width: 100%;box-sizing: border-box;padding: 6px 12px;"></textarea>
		<br></br>
		<input type="submit" style="background: white;color: black" value="Erstellen" class="btn btn-lg btn-primary btn-block"/>
	</form>
</div>

</body>
