<?php

session_start();
unset($_SESSION['challenge_accepted']);
include_once 'autoload.php';

if (isset($_SESSION['forgotten_user'])) {
	if ($_SESSION['forgoten_user']->reset_answer == crypt($_POST['answer'], 'dLp#32A')) {
		$_SESSION['challenge_accepted'] = true;
		header('Location: /?reset');
	}
	else {
		session_destroy(); session_start();
		$_SESSION['error'] = 'Reset Challange failed';
		header('Location: /?reset_chalenge');
	}
}
