<?php

include_once 'autoload.php';
session_start();

if (isset($_SESSION['challenge_accepted'])) {
	if ($_POST['password'] != $_POST['password_confirm']) {
		$_SESSION['error'] = 'Your password\'s must match';
		header('Location: /?reset');
	}else{
		if (strlen($_POST['password']) < 8) {
			$_SESSION['error'] = 'Password must be longer than 7 characters';
			header('Location: /?reset');
		} else {
			$password = hash("sha256",$_POST['password'] . 'alPha548*3jasc');
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
}

?>
