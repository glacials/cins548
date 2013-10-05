<?php

require_once 'autoload.php';

// Setting variables...
$username = $_POST['email'];
$password = crypt($_POST['password'],'dLp#32A');
$password_confirm = crypt($_POST['password'],'dLp#32A');
$gender = $_POST['gender'];

// Redirect back to signup page if any of the fields are empty, or if the passwords don't match eachother.
if (!(empty($username) or empty($password) or empty($password_confirm) or empty($gender)) or $password == $password_confirm) {

	// Create new User object with variables, initialize data.
	$user = new User(0,$username,$password,0,$gender);
	if ($user->save('insert') != false)
		header('Location: /?browse');
	else
		header('Location: /?signup');
}
else
	header ('Location: /?signup');
?>
