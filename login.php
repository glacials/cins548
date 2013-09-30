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

if ($out != NULL) {
	echo "TRUE\n";
	$_SESSION['logged_in'] = true;
	$_SESSION['user_id'] = $out;
}
else {
	// redirect to /index.php ?
}

?>
