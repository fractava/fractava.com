<?php
require($_SERVER['DOCUMENT_ROOT'] . "/inc/autoload.inc.php");

//use database\simpleDatabaseQuery;
//$query = new simpleDatabaseQuery("SELECT * FROM blog;",array());
//var_dump($query->fetch());

use user\userManagement;

$user = userManagement::findById(2);
//var_dump($user->setAttribute("email", "trefflerj@web.de"));

/*use database\databaseController;

$databaseController = new databaseController();
var_dump($databaseController->getColumnsOfTable("blog"));
*/