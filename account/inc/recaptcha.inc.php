<?php
	function recaptcha_correct(String $secret , String $response){
		$ch = curl_init("https://www.google.com/recaptcha/api/siteverify"); // cURL ínitialisieren
		curl_setopt($ch, CURLOPT_HEADER, 0); // Header soll nicht in Ausgabe enthalten sein
		curl_setopt($ch, CURLOPT_RETURNTRANSFER , true);
		curl_setopt($ch, CURLOPT_POST, 1); // POST-Request wird abgesetzt
		curl_setopt($ch, CURLOPT_POSTFIELDS, 'secret=' . $secret . '&response=' . $response . ''); // POST-Felder festlegen, die gesendet werden sollen
		$recaptchaPOST = curl_exec($ch); // Ausführen
		curl_close($ch); // Objekt schließen und Ressourcen freigeben
	
		$recaptchaPOSTArray = json_decode($recaptchaPOST, true);
		//var_dump($recaptchaPOSTArray);
		if($recaptchaPOSTArray["success"]){
			return true;
		}else {
			return false;
			}
	}

