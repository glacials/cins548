<?php

include_once 'autoload.php';
session_start();

$crypt_answer = crypt($_POST['answer'],'dLp#32A');

if (isset($_SESSION['forgotten_user'])) {
	if ($_SESSION['forgotten_user']->reset_answer == $crypt_answer) {
		$_SESSION['challenge_accepted'] = true;
		header('Location: /?reset');
	}
	else {
		session_destroy(); session_start();
		$_SESSION['error'] = 'Reset Challenge failed';
		header('Location: /?reset_challenge');
	}
}
