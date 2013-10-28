<?php

require_once 'autoload.php';

// Setting variables...
$username = $_POST['email'];
$password = hash("sha256", $_POST['password'] . 'alPha548*3jasc');
$password_confirm = hash("sha256", $_POST['password_confirm'] . 'alPha548*3jasc');
$gender = $_POST['gender'];
$question = $_POST['question'];
$answer = hash("sha256", $_POST['answer'] . 'alPha548*3jasc');
$address = $_POST['address'];

if (strlen($_POST['password']) < 8) {
	$_SESSION['error'] = 'Password must be longer than 7 characters';
	header('Location: /?signup');
} else {
	if ($gender != 'm' || $gender != 'f') {
		$_SESSION['error'] = 'Invalid gender, please try again.';
		header('Location: /?signup');
		exit();
	} else {

// Redirect back to signup page if any of the fields are empty, or if the passwords don't match each other.
if (empty($username)         || empty($password) ||
    empty($password_confirm) || empty($gender)   ||
    empty($question)	     || empty($answer)   ||
    empty($address)	     || $password != $password_confirm
   ) {
  $_SESSION['error'] = 'All fields must be correctly filled out.';
  header('Location: ?signup');
   } else {
	   if ((strlen($username) > 30) ||
	       (strlen($password) > 64) ||
	       (strlen($gender) > 1)    ||
	       (strlen($question) > 100)||
	       (strlen($answer) > 64)   ||
	       (strlen($address) > 100)) {
		       $_SESSION['error'] = 'One or more input fields are too long.';
		       header('Location: ?signup');
	       } else {
  			// Create new User object with variables, initialize data.
  			$user = new User(0, $username, $password, 0, $gender, 0, $question, $answer, $address);
  			if ($user->save('insert')) {
    				// We are making them login so their user object will be updated (user_id, updated, etc.)
    				$_SESSION['notice'] = 'Account created! Please login.';
    				header('Location: ?login');
  			} else {
    				$_SESSION['error'] = 'There was a problem making your account. Please try again later.';
    				header('Location: ?signup');
  			}
	       	}
   }
	}
}
?>
