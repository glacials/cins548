<?
/*
 * This page will authenticate users and create session variables, that tells
 * the webapp that the user is authenticated, and they are allowed to browse to
 * other pages. Input will be given via a POST from the login.html template.
 */

function __autoload($class_name) {
	include 'classes/' . $class_name . '.php';
}

$db = new Database;

$out = $db->verify_creds($_POST['username'],$_POST['password']);

if ($out) {
	echo "TRUE";
	// create session information here.
}
else {
	// redirect to /index.php ?
}

?>
