<?php

/*
 * forgot.php
 * This script will get data posted to it from ?forgot.
 * It will recieve an email address, and then create a session
 * variable that stores the userobject for that particular email.
 * $_SESSION[forgotten_user'].
 */

session_start();
require_once 'autoload.php';

$db = new Database;

$forgotten_user = $db->get_user_from_username($_POST['email']);

if($forgotten_user) {
	$_SESSION['forgotten_user'] = $forgotten_user;
	header('Location: /?reset');
}
else {
	$_SESSION['error'] = 'Error, retriving account details';
	header('Location: /?forgot');
}