<?php
 
//Tragt hier eure Verbindungsdaten zur Datenbank ein
$db_host = 'localhost';
$db_name = 'elm';
$db_user = 'elm';
$db_password = '#GreenfarmerIsTheBest';
$pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
