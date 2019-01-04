<?php
function getSiteURL($withoutProtocol) {
	$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
	if(withoutProtocol){
		return $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/';
	}else{
		return $protocol.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/';
	}
}
function isSSL(){
	return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? true : false;
}

function redirectToSSL(){
	//if(isSSL() == false){
			//header("location:https://" . getSiteUrl(true));
	//}
	$use_sts = TRUE;

	if ($use_sts && isset($_SERVER['HTTPS'])) {
		header('Strict-Transport-Security: max-age=500');
	} elseif ($use_sts && !isset($_SERVER['HTTPS'])) {
		header('Status-Code: 301');
		header('Location: https://'.$_SERVER["HTTP_HOST"].$_SERVER['REQUEST_URI']);
	}
}
?>
