<?php 
	session_start();
	require_once($_SERVER['DOCUMENT_ROOT'] . "/account/inc/config.inc.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/account/inc/functions.inc.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/account/inc/blockedIPs.inc.php");
	include($_SERVER['DOCUMENT_ROOT'] . "/account/templates/header.inc.php");
	$user = check_user(true);
?>

<head>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-112803937-1"></script>
		<script>
  		window.dataLayer = window.dataLayer || [];
  		function gtag(){dataLayer.push(arguments);}
  		gtag('js', new Date());
  		gtag('config', 'UA-112803937-1');
	</script>
	
</head>

<body style = "background-color: black;">
	<?php	
		$statement = $pdo->prepare("SELECT comments_blocked FROM users WHERE id = :id");
		$result = $statement->execute(array('id' => $_SESSION['userid']));
		$comments_blocked = $statement->fetch();
		
			$thread_id = $_GET['thread_id'];
			$text = $_POST["text"];
			if(!comments_blocked()){
			//Highest Post id
			$statement = $pdo->prepare("SELECT post_id FROM Forum_posts WHERE thread_id = :thread_id ORDER BY post_id DESC LIMIT 1");
			$statement->execute(array("thread_id" => $thread_id));
			$null = true;
			while($row = $statement->fetch()) {
				$post_id = $row["post_id"]+1;
				echo $post_id;
				$null = false;
			}
			if($null){
				$post_id = 1;
				echo $post_id;
			}
			
			//Post
			//echo "INSERT INTO Forum_posts ( post_id , text , thread_id ,user_id) VALUES (" . $post_id . " , \"" . $text . "\" , " . $thread_id . ", " . $user['id'] . ")";
			$statement = $pdo->prepare("INSERT INTO Forum_posts ( post_id , text , thread_id ,user_id) VALUES (:post_id , :text , :thread_id, :creator_id)");
			$result = $statement->execute(array('post_id' => $post_id , 'text' => $text , 'thread_id' => $thread_id , 'creator_id' => $user['id']));
			//echo "<p style = \"color:white;\">Forum Eintrag erstellt : <a style = \"color:white; \" href = \"view-thread.php?eintrag=" . $thread_id . "\">Anschauen</a></p>";
		}
			header("location: http://fractava.com/forum/view-thread.php?eintrag=". $thread_id);
	?>

</body>
