<?php
	/* INFO, HILFE & QUELLE: http://www-coding.de/url-requests-mit-php/
	 *
	 * Bitte nutze diese Funktion nur bei URLs, bei denen dessen Inhaber nichts gegen einen automatisierten Abruf einzuwenden haben.
	 *
	 * @url vollständige URL inkl. http/https
	 * (@setUserAgent wenn false -> wird der Benutzer-Agent des Nutzers verwendet, sonst der entsprechende Wert)
	 * (@usePost true -> POST, sonst -> GET)
	 * (@additionalHeaders zusätzliche Header im Format: "Header-Name1: Wert1\r\nHeader-Name2: Wert2\r\n")
	 * (@content content des Requests im Format: "feld1=wort1+wort2&feld2=true&feld3[]=wert1&feld3[]=wert2")
	 */
	
	function urlRequest($url, $setUserAgent=false, $usePost=false, $additionalHeaders='', $content='') {
		return file_get_contents($url, false, stream_context_create(array('http' => array('method' => (($usePost) ? 'POST' : 'GET'), 'header' => "User-Agent: ".(($setUserAgent) ? $setUserAgent : $_SERVER['HTTP_USER_AGENT'])."\r\n"."Content-Type: application/x-www-form-urlencoded;charset=UTF-8\r\n".$additionalHeaders, 'content' => $content))));
	}
	
	// Beispiel 1 -> einfacher URL-Abruf //
	//echo urlRequest('http://www-coding.de/url-requests-mit-php/');
	
	// Beispiel 2 -> POST-Abruf mit eigens definiertem User-Agent //
	//echo urlRequest('http://test-seite.de/formular/', 'Mozilla/5.0 (X11; Ubuntu; Linux x86; rv:28.0) Gecko/20100101 Firefox/28.0', true, '', 'feld1=wort1+wort2&feld2=true&feld3[]=wert1&feld3[]=wert2');
?>
