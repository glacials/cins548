<?php

session_start();

if (!isset($_SESSION['user'])) {
	$_SESSION['error'] = 'You must be logged in to checkout. Please login.';
	header('Location: /?login');
}

?>
