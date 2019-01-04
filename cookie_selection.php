<?php
//if($_GET["selection"] != ""){
	if($_GET["selection"] == 0){
		//gar keine Cookies
	}else if($_GET["selection"] == 1){
		//funktionale Cookies
		setcookie("cookie_selection","1",time()+10080);
	}else if($_GET["selection"] == 2){
		//alle Cookies
		setcookie("cookie_selection","2",time()+10080);
	}
//}
header("location: https://fractava.com");
?>
