<?
/*
 * This page will authenticate users and create session variables, that tells
 * the webapp that the user is authenticated, and they are allowed to browse to
 * other pages. Input will be given via a POST from the login.html template.
 */

function __autoload($class_name) {
	include 'classes/' . $class_name . '.php';
}

session_start();

$db = new Database;

$out = $db->verify_creds($_POST['username'],$_POST['password']);

if ($out != false) {
	// Creds are correct. Create session variables.
	$_SESSION['user_id'] = $out['user_id'];
	$_SESSION['is_admin'] = $out['is_admin'];
}
else {
	// Creds are incorrect.
	header('Location: /index.php');
}

?>
