<?php
 
//Tragt hier eure Verbindungsdaten zur Datenbank ein
$db_host = 'localhost';
$db_name = 'fractemtron';
$db_user = 'fractemtron';
$db_password = '#WeLoveMySQL';
$pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
