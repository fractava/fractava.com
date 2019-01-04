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
		$post_id = $_GET['post_id'];
		$thread_id = $_GET['thread_id'];
		
		if(!empty($post_id) && !empty($thread_id) && $post_id != 0){
			$statement = $pdo->prepare("SELECT user_id FROM Forum_posts WHERE post_id = :post_id AND thread_id = :thread_id");
			$statement->execute(array("post_id" => $post_id, "thread_id" => $thread_id));
			$user_id = $statement->fetch();

			
			if($user_id["user_id"] == $_SESSION['userid']){
				$statement = $pdo->prepare("UPDATE Forum_posts SET deleted = 1 WHERE post_id = :post_id AND thread_id = :thread_id");
				$statement->execute(array("post_id" => $post_id, "thread_id" => $thread_id));
			}
		}
		
		header("location: http://fractava.com/forum/view-thread.php?eintrag=". $thread_id);
	?>

</body>
