<?php

include_once 'autoload.php';
session_start();

if (isset($_SESSION['challenge_accepted'])) {
	if ($_POST['password'] != $_POST['password_confirm']) {
		$_SESSION['error'] = 'Your password\'s must match';
		header('Location: /?reset');
	}else{
		$password = crypt($_POST['password'], 'dLp#32A');
		$old_user = $_SESSION['forgotten_user'];

		// Creating an updated User object.
		$user = new User($old_user->id, $old_user->username,
			$password, $old_user->is_admin, $old_user->gender,
			$old_user->updated, $old_user->reset_question,
			$old_user->reset_answer, $old_user->address);

		$result = $user->save('update');
		if ($result) {
			session_destroy(); session_start();
			$_SESSION['notice'] = 'Account Recovered. Please login.';
			header('Location: /?login');
		} else {
			session_destroy(); session_start();
			$_SESSION['error'] = 'Error Updating Your Account.';
			header('Location: /?login');
		}

	}
}

?>