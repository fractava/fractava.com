<?php
require($_SERVER['DOCUMENT_ROOT'] . "/inc/autoload.inc.php");

/*use database\simpleDatabaseQuery;
$query = new simpleDatabaseQuery("SELECT * FROM blog;",array());
var_dump($query->fetch());
*/

/*use user\userManagement;
$user = userManagement::findByEmail("trefflerj@web.de");
var_dump($user->getAttribute("username"));
//var_dump($user->setAttribute("email", "trefflerj@web.de"));
*/

/*use database\databaseController;
$databaseController = new databaseController();
var_dump($databaseController->getColumnsOfTable("blog"));
*/

/*use password\passwordManagement;
var_dump(passwordManagement::checkPassword(2, ""));*/

/*use password\encryption;
var_dump(encryption::checkPassword("", '$2y$10$jtBaPoXYJLk.Nthw7gcDh.jVCBAMqOdl8rMvbZQdNvZ9m5MNjfnm2'));
*/

/*use session\sessionManager;
$sessionManager = new sessionManager();
if($sessionManager->isLoggedIn()) {
    var_dump($sessionManager->getLoggedInUser()->getAttribute("email"));
}else {
    echo "not logged in";
}*/

use email\email;

$email = new email();
$email->sendStyled("mail@fractava.com", "trefflerj@web.de", "Test", "<b>Trololololo 3</b>", "support@fractava.com");