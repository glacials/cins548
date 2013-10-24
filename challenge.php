<?php

include_once 'autoload.php';
session_start();

$crypt_answer = hash("sha256",$_POST['answer'].'alPha548*3jasc');

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
